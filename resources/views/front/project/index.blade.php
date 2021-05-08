@extends('front.layouts.ec')
@section('title', 'Project')
@section('content')
    <div class="page-white page-project pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('project') !!}
            </nav>
        </div>
        <div class="container">
            <div class="content-page">
                <div class="row">
                    <div class="col-md-3 col-sm-3 hidden-xs">
                        <div class="">
                            @include('front.project.sidebar')
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                @if(count($project) == 0)
                                    <div class=" form-request-info text-center">		
                                        <span style="color:red;">{{ trans('PENCARIAN TIDAK TERSEDIA') }}</span><br />
                                        {{ trans('Maaf project yang Anda cari tidak tersedia. Silahkan coba pencarian yang lain.') }}
                                    </div>
                                @endif
                                
                                @if(count($project) > 0)
                                    <div class="row projects">
                                        @foreach($project as $row_project)
                                            <?php 
                                                $data_project = array(
                                                    'project' => $row_project,
                                                    'col_class' => "col-md-4 col-xs-4 col-lg-3"  
                                                );  
                                                echo \Lintas\libraries\CBlocks::render('project-card', $data_project);
                                            ?>
                                        @endforeach
                                    </div>
                                    <div class="container-search-pagination clearfix">{{ $project->links() }}</div> 
                                @endif 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection