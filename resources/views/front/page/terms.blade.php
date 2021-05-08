@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div class="page-container pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('page.term') !!}
            </nav>
        </div>
        <div class="container">
            <div class=" row">			
                <div class="col-md-3">
                    <?php
                        echo \Lintas\libraries\CBlocks::render('page/sidebar');
                    ?>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            {{ __(ucwords($title)) }}
                        </div>
                        <div class="card-body">
                            {!! $content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection