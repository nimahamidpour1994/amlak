<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function save(Request $request)
    {
             $array = [];

            // DIRECTORY
            $locationimg = public_path('/storage/advertisment/');
            $locationtumbnail = public_path('/storage/advertisment/thumbnail');
            // DIRECTORY

            $image = $request->file('file');
            $input['imagename'] = time().rand(0,999999) . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());

            // CREATE IMG
            $img->fit(600)->save($locationimg . '/' . $input['imagename']);
            // CREATE THUMBNAIL IMG
            $img->fit(150)->save($locationtumbnail . '/' . $input['imagename']);

            // CREATE RESPONSE TRUE
            $array['message'] = 'success';
            $array['src'] = $input['imagename'];

            // SAVE IMG TO SESSION
            if (!session()->get('img'))
            {
                $img = [];
                $img[0] = ['src' => $array['src'], 'type' => 'new'];
                session()->put('img', $img);
                $array['test'] = $array['src'];
            }
            else
            {
                $img = session()->get('img');
                $count = count($img);
                $img[$count] = ['src' => $array['src'], 'type' => 'new'];
                session()->put('img', $img);
            }
            // SAVE IMG TO SESSION

            return json_encode($array);
    }

    public function delete(Request $request)
    {
        $items = session()->get('img');
        for ($i = 0; $i < 16; $i++)
            if (isset($items[$i]))
                if ($items[$i]['src'] == $request->src) {

                    if ($items[$i]['type']=='old')
                    {
                        Meta::where([['value',$items[$i]['src']],['key','img']])->delete();
                    }
                    unset($items[$i]);
                    $items=array_values($items);
                    session()->put('img', $items);
                    unlink('storage/advertisment/thumbnail/' . $request->src);
                    unlink('storage/advertisment/' . $request->src);
                    return 'true';
                }
        return 'false';
    }
}
