@extends('layout')

@section('content')
    <!--main content start-->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6">
                                <article class="post post-grid">
                                    <div class="post-thumb">
                                        <a href="{{route('post.show' , $post->slug)}}"><img src="{{$post->getImage()}}"
                                                                                            alt=""></a>

                                        <a href="{{route('post.show' , $post->slug)}}"
                                           class="post-thumb-overlay text-center">
                                            <div class="text-uppercase text-center">View Post</div>
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <header class="entry-header text-center text-uppercase">

                                            @include('partials._category' , ['posts' => $posts])
                                            <h1 class="entry-title"><a
                                                        href="{{route('post.show' , $post->slug)}}">{{$post->title}}</a>
                                            </h1>


                                        </header>
                                        <div class="entry-content">
                                            <p>
                                                {!! $post->description !!}
                                            </p>

                                            <div class="social-share">
                                                <span class="social-share-title pull-left text-capitalize">By Rubel On {{$post->getDate()}}</span>
                                            </div>
                                        </div>
                                    </div>

                                </article>
                            </div>
                        @endforeach
                    </div>
                    {{$posts->links()}}
                    {{--<ul class="pagination">--}}
                    {{--<li class="active"><a href="#">1</a></li>--}}
                    {{--<li><a href="#">2</a></li>--}}
                    {{--<li><a href="#">3</a></li>--}}
                    {{--<li><a href="#">4</a></li>--}}
                    {{--<li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>--}}
                    {{--</ul>--}}
                </div>
                @include('pages._sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection