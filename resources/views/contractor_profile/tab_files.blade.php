<div class="row">

    <section class="box-typical files-manager">
        <div class="files-manager-panel">
            <div class="files-manager-panel-in" style="margin-left: 0px;">
                <header class="files-manager-header">
                    <div class="files-manager-header-left" style="width: 100%;">
                        <div class="js-tab-files-dropzone">
                            <form class="pull-left">
                                <span class="btn btn-rounded btn-file">
                                    <span><i class="font-icon-left font-icon-upload-2"></i>Загрузить</span>
                                    <input type="file" name="files" >
                                </span>
                                {!! csrf_field() !!}
                                {{-- <input type="hidden" name="id" value="{{$user->id}}" /> --}}
                            </form>
                            <div class="pull-left js-contractor-profile-tab-company-files-icons">
                            </div>
                        </div>

                    </div>
                    <div class="files-manager-header-right">
                    </div>
                </header><!--.files-manager-header-->

                <div class="files-manager-content">
                    <div class="files-manager-content-in scrollable-block">
                        <div class="fm-file-grid js-tab-files-list">
                        </div>
                    </div><!--.files-manager-content-in-->
                </div><!--.files-manager-content-->

                <section class="files-manager-aside">
                    <div class="files-manager-aside-section js-contractor-profile-tab-company-files-info">
                    </div>
                </section><!--.files-manager-aside-->
            </div><!--.files-manager-panel-in-->
        </div><!--.files-manager-panels-->
    </section><!--.files-manager-->

</div>
