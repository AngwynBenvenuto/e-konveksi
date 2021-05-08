<div class="card mb-3">
    <div class="card-header">
        <div class="product-breadcrumb text-center">
            {{ __('Filter') }}
            <div class="text-small">
                @if(strlen($keyword))
                    {{ trans('Pencarian berdasarkan kata kunci') }}
                    <span>{{ $keyword }}</span>
                @endif
            </div>
        </div>
       
    </div>
    <div class="card-body">
       <div class="product-sort">
            <div class="sorting">
                <form class="" id="filter_project" action="{{ route('project') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label class="mb-0">{{ __('Show') }}</label>
                        <select class="form-control custom-select" name="view_page" id="view_page">
                            <option value="" disabled selected>{{ __('-- Semua --') }}</option>
                            <?php
                                $optionArr = ['12', '24', '36'];
                                for($i = 0; $i < count($optionArr); $i++) {
                                    $selected = '';
                                    echo "<option value='{$optionArr[$i]}' $selected>{$optionArr[$i]}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">{{ __('Urutkan') }}</label>
                        <select class="form-control custom-select">
                            <option value="" disabled selected>{{ __('-- Semua --') }}</option>
                            <?php
                                $optionArr = ['A-Z', 'Z-A', 'Popular'];
                                for($i = 0; $i < count($optionArr); $i++) {
                                    echo "<option value='{$optionArr[$i]}'>{$optionArr[$i]}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">{{ __('Kata Kunci') }}</label>
                        <input type="text" id="keyword" name="keyword" class="form-control" value="{{ $keyword }}">
                    </div>
                    <input id="btnSubmit" type="submit" class="btn btn-default bg-primary" value="Search">
                </form>
            </div>

       </div>
    </div>
</div>

    