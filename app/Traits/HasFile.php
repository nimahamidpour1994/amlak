<?php

namespace App\Traits;

trait HasFile
{
    /**
     * @var string $file_disk
     */
    protected $file_disk;

    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @var string $file_source
     */
    protected $file_source;

    /**
     * @var string $file_directory
     */
    protected $file_directory;

    /**
     * @var string $file_sub_folder
     */
    protected $file_sub_folder;

    /**
     * @var array $file_image
     */
    protected $file_image;

    /**
     * @return  void
     */
    public function initializeHasFile()
    {
        $config = (array) $this->has_file;
        $this->file_source = $config['source'];
        $this->file_disk = array_key_exists('disk', $config) ? $config['disk'] : 'public';
        $this->file_name = array_key_exists('name', $config) ? $config['name'] : '';
        $this->file_sub_folder = array_key_exists('sub_folder', $config) ? $config['sub_folder'] : 'id';
        $this->file_directory = array_key_exists('directory', $config) ? $config['directory'] : \Str::snake(class_basename($this));
        $this->file_image = array_key_exists('image', $config) ? $config['image'] : [];
        if ($this->file_disk !== 'public' && !in_array($this->file_source, $this->hidden)) {
            $this->hidden[] = $this->file_source;
        }
        static::deleting(function ($model) {
            $this->deleteFile($model);
        });

        static::saving(function ($model) {
            if (\Request::hasFile($this->file_source) || $this->hasUploadFile($model)) {
                if ($model->exists) {
                    $this->deleteFile($model);
                }
                $this->saveFile($model);
            }
        });

        static::created(function ($model) {
            $model->renameFile(); // for undefined id folder
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return  bool
     */
    protected function hasUploadFile($model)
    {
        return gettype($model[$this->file_source]) === 'object' && get_class($model[$this->file_source]) === 'Illuminate\Http\UploadedFile';
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return  void
     */
    protected function saveFile($model)
    {
        $fileSource = $this->file_source;
        $fileName = $this->getFileName($model);
        $fileDirectory = $this->getFileDir($model);
        if ($this->hasUploadFile($model)) {
            $file = $model[$this->file_source];
        } else {
            $file = \Request::file($fileSource);
        }
        if (is_array($file)) $file = $file[0];
        if ($file === null) return;

        $extension = $file->extension();

        if (filled($this->file_image)) {
            $file = \Intervention\Image\Facades\Image::make($file);
            foreach ($this->file_image as $method => $options) {
                $file->$method(...$options);
            }
            $file = (string) $file->encode();
        }

        $path = $fileDirectory . '/' . $fileName . '.' . $extension;

        $this->getStorage()->deleteDirectory($path);

        if (is_string($file)) {
            $this->getStorage()->put($path, $file);
        } else {
            $this->getStorage()->putFileAs($fileDirectory, $file, $fileName . '.' . $extension);
        }

        $model->$fileSource = $this->getFilePath($path, false);

        if (\Schema::hasColumn((new static())->getTable(), 'extension')) {
            $model->extension = $extension;
        }
    }

    /**
     * @return  bool
     */
    public function renameFile()
    {
        $model = $this;
        if (
            blank($model[$this->file_source]) ||
            !$this->getStorage()->exists($model[$this->file_source]) ||
            \Str::startsWith($model[$this->file_source], ['http', 'www.'])
        ) {
            return false;
        }

        $ext = $model->extension;
        if (blank($ext)) {
            $tmp = explode('.', $model[$this->file_source]);
            if (count($tmp) > 1) $ext = end($tmp);
        }

        $oldPath = $this->getFilePath($model[$this->file_source]);
        $newPath = $this->getFileDir($model) . '/' . $this->getFileName($model) . (filled($ext) ? ('.' . $ext) : '');

        if ($oldPath !== $newPath) {
            $this->getStorage()->move($oldPath, $newPath);
            $model->update([
                $this->file_source => $this->getFilePath($newPath, false)
            ]);
            return true;
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return  void
     */
    public function deleteFile($model)
    {
        if (
            filled($model[$this->file_source]) &&
            $this->getStorage()->exists($model[$this->file_source])
        ) {
            $this->getStorage()->delete($this->getFilePath($model[$this->file_source]));
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return  string
     */
    public function getFileName($model)
    {
        if (filled($this->file_name) && filled($model[$this->file_name]) && $this->file_name !== $this->file_source) {
            $fileName = $model[$this->file_name];
        } else {
            $fileName = $this->file_name;
        }
        if (filled($model->part) && $model->part !== 0) {
            $fileName .= '_p' . $model->part;
        }
        if (filled($model->version) && $model->version !== 0) {
            $fileName .= '_v' . $model->version;
        }
        if ($this->file_disk !== 'public') {
            $fileName .= '_' . microtime(true) . \Str::random(20);
        }
        return \Str::slug($fileName, '_');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return  string
     */
    public function getFileDir($model)
    {
        $fileDirectory = $this->file_directory;
        if (filled($model[$this->file_sub_folder])) {
            $fileDirectory .= '/' . $model[$this->file_sub_folder];
        } elseif (filled($this->file_sub_folder) && $this->file_sub_folder !== 'id') {
            $fileDirectory .= '/' . $this->file_sub_folder;
        }
        return $fileDirectory;
    }

    /**
     * @param  string $path
     * @param  bool $getting
     *
     * @return  string
     */
    public function getFilePath(string $path, bool $getting = true)
    {
        if ($this->file_disk === 'public') {
            if ($getting) {
                $path = \Str::replaceFirst('/storage/', '', $path);
            } else {
                $path = '/storage/' . $path;
            }
        }
        return $path;
    }

    /**
     * @return  \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage()
    {
        if ($this->file_disk === 'ftp' && config('app.debug')) {
            return \Storage::disk('public');
        }
        return \Storage::disk($this->file_disk);
    }
}
