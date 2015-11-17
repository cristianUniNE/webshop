<div class="col-md-6">
    <div class="form-group ">
        <label class="control-label">Titre</label>
        {!! Form::select('adresse[civilite_id]', [4 => '',1 => 'Monsieur',2 => 'Madame',3 => 'Me'] , null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="control-label">Entreprise</label>
        <input type="text" name="adresse[company]" class="form-control" value="" placeholder="Entreprise">
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label class="control-label"><span class="text-danger">Prénom</span></label>
            <input type="text" name="adresse[first_name]" data-parsley-required class="form-control form-required" value="" placeholder="Prénom">
        </div>
        <div class="col-md-6">
            <label class="control-label"><span class="text-danger">Nom</span></label>
            <input type="text" name="adresse[last_name]" data-parsley-required class="form-control form-required" value="" placeholder="Nom">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">E-mail</label>
        <input type="email" name="adresse[email]" data-parsley-required class="form-control form-required" value="" placeholder="E-mail">
    </div>

</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="control-label"><span class="text-danger">Adresse</span></label>
        <input type="text" name="adresse[adresse]" data-parsley-required class="form-control form-required" value="" placeholder="Adresse">
    </div>
    <div class="form-group row">
        <div class="col-md-8">
            <label class="control-label">Complément d'adresse</label>
            <input type="text" name="adresse[complement]" class="form-control" value="" placeholder="Complément d'adresse">
        </div>
        <div class="col-md-4">
            <label class="control-label">Case Postale</label>
            <input type="text" name="" class="form-control" value="" placeholder="Case Postale">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <label class="control-label"><span class="text-danger">NPA</span></label>
            <input type="text" name="adresse[npa]" data-parsley-required class="form-control form-required" value="" placeholder="Code postal">
        </div>
        <div class="col-md-8">
            <label class="control-label"><span class="text-danger">Ville</span></label>
            <input type="text" name="adresse[ville]" data-parsley-required class="form-control form-required" value="" placeholder="Localité">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label class="control-label">Canton</label>
            <?php $cantons = $cantons->lists('title','id')->all(); ?>
            {!! Form::select('adresse[canton_id]', [0 => 'Choix'] + $cantons , null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6">
            <label class="control-label">Pays</label>
            {!! Form::select('adresse[pays_id]', $pays->lists('title','id')->all() , 208, ['class' => 'form-control']) !!}
        </div>
    </div>

</div>