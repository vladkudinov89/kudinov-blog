@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blank page
                <small>it all starts here</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            {{Form::open([
            'route' => 'posts.store',
            'files' => true
            ])}}
                        <!-- Default box -->
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Листинг сущности</h3>
                                @include('admin.errors')
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group">
                                    <a href="{{route('posts.create')}}" class="btn btn-success">Добавить</a>
                                </div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Категория</th>
                                        <th>Теги</th>
                                        <th>Картинка</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @foreach($posts as $post)
                                        <td>{{$post->id}}</td>
                                        <td>{{$post->title}}
                                        </td>
                                        <td>Обучение</td>
                                        <td>Laravel, PHP</td>
                                        <td>
                                            <img src="../assets/dist/img/boxed-bg.jpg" alt="" width="100">
                                        </td>
                                        <td>
                                            <a href="{{route('posts.edit' , $post->id)}}" class="fa fa-pencil"></a>
                                            {{Form::open(['route' => ['posts.destroy' , $post->id ]  ,
                                                'method' => 'delete' ]) }}
                                            <button onclick="return confirm('Вы уверены?')" type="submit" class="delete">
                                                <a class="fa fa-remove"></a>
                                            </button>

                                            {{Form::close()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        {{Form::close()}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection