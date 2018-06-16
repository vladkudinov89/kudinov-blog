@if($post->hasCategory())
    <h6><a href="{{route('category.show' , $post->getCategoryTitle())}}">category: {{$post->getCategoryTitle()}}</a>
    </h6>
@endif