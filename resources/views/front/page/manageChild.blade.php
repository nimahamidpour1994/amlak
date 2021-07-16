@foreach($childs as $child)
    <li class="filter-category-list__item--inactive filter-category-list__item inactive">
        @if(count($child->Child))

            <button class="btn filter-category-list__item-field filter-category-list__item-link shadow-none"
                    onclick="openSubCategory(this,'{{$child->id}}','{{$child->Parent->id}}','child')"
                    value="{{$child->id}}">
                {{$child->name}}
            </button>

            <div  class="filter-category-list mr-2">
                <button class="btn filter-category-list__item-field filter-category-list__item-link shadow-none"
                        onclick=""
                        value="{{$category->id}}">
                    {{$child->Parent->name}}
                </button>
                <div id="div{{$child->id}}" class="fa-num text-divar mb-2">{{$child->name}}</div>

               <ul> @include('front.page.manageChild',['childs' => $child->Child])</ul>
            </div>

        @else
            <button class="btn filter-category-list__item-field filter-category-list__item-link shadow-none"
                    onclick="openSubCategory(this,'{{$child->id}}','{{$child->Parent->id}}','finalchild')"
                    value="{{$child->id}}">
                {{$child->name}}</button>

            <div id="div{{$child->id}}" class="filter-category-list mr-3">{{$child->name}}</div>
        @endif

    </li>
@endforeach
