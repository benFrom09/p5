<div class="col-md-6" id="dashboard">
    


    <form action="{{route('post.create',$group)}}" method="post" enctype="multipart/form-data" id="post-form">
        {{csrf_field()}}
        <div class="panel panel-default">
            <div class="panel-heading">Ajouter un statut</div>

            <div class="panel-body">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <div class="form-group">
                    <label for="content">exprimez-vous</label>
                    <textarea class="form-control" name="content" id="content"></textarea>
                </div>


            </div>
            <div class="panel-footer clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <label for="file-upload" class="c-file-upload">
                                    <i class="fa fa-image"></i>
                                </label>
                        <input type="file" name="post_images" id="file-upload">
                    </div>
                    <div class="col-md-6">
                        <button id="post-submit" class="btn btn-info pull-right btn-sm"><i class="fa fa-plus"></i> Ajouter un statut</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <section class="post-dashboard">
     @include('layout.partials.top_20_post' )
    </section>


    <div class="modal" id="edit-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="post-content"> editer </label>
                            <textarea class="form-control" name="post-content" id="post-content" rows="10"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



</div>