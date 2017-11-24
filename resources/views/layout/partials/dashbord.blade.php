<div class="col-md-6 dashboard">
    <div class="overlay"></div>
    <div class="float content">
        <form class="dashboard-form" action="" method="post">
        {{csrf_field()}}
            <div class="float-top">
                <input class="form-control" type="text" name="content" id="dashboard-input" placeholder="publier un cours">
            </div>
            <div class="float-bottom">
                <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>

            </div>
        </form>
    </div>
    <div class="dashboard-list content">
        
    </div>
</div>