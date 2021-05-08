<div id="modal-cropper-js" class="modal modal-cropper" >
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h3>Cropper</h3>
                <div class="btn-group btn-group-header-modal ml-auto" style="margin-right:5px">
                    <button type="button" class="btn btn-primary btn-zoom-in" data-method="zoom" data-option="0.1" title="Zoom In">
                        <span class="docs-tooltip" data-toggle="tooltip" title="">
                            <span class="fa fa-search-plus"></span> 
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary btn-zoom-out" data-method="zoom" data-option="-0.1" title="Zoom Out">
                        <span class="docs-tooltip" data-toggle="tooltip" title="">
                            <span class="fa fa-search-minus"></span> 
                        </span>
                    </button>
                </div>
                <button type="button" class="close">
                    <i class="fas fa-times"></i>
                </button>
                <span class="loader"></span>
            </div>
            <div class="modal-body opened">
                <div class="cropper-image-container">
                    <img class="img-responsive" src="{{ asset('public/img/no_image.png') }}" height="auto" width="100%"/>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row" id="actions">
                    <div class="col-md-12 docs-buttons">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-crop" data-method="crop" data-option="crop" title="Crop">
                                <span class="docs-tooltip" data-toggle="tooltip" title="">
                                    <span class="fa fa-crop"></span> OK
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function ($) {
        var Cropper = window.Cropper;
        var URL = window.URL || window.webkitURL;
        var modalCropper = $('#modal-cropper-js');
        var container = modalCropper.find('.cropper-image-container');
        var image = container.find('img');
        $('.btn-zoom-in').click(function (event) {
            image.cropper('zoom', 0.1);
        });

        $('.btn-zoom-out').click(function (event) {
            image.cropper('zoom', -0.1);
        });
        modalCropper.find('.close').click(function (e) {
            modalCropper.modal('hide');
        });
    })(jQuery);
</script>