@extends('themes.default1.agent.layout.agent')
@section('content')
<section class="content-heading-anchor">
    <h2>
        Form Builder 
    </h2>
</section>
<link rel="stylesheet" type="text/css" media="screen" href="http://formbuilder.online/assets/css/form-builder.min.css">
<div class="box box-primary">
    <div class="box-header">
        <h3>Form Builder</h3>
        <div class="pull-right">
            <?php $form_controller = new \App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController(); 
            echo $form_controller->show($form->id,'popup');
            ?>
            
        </div>
    </div>
    <div class="box-body">
        <div class="row">

            <div id="response" class="col-md-12"></div>
            <div class="col-md-6">
                {!! Form::label('title','Title') !!}
                {!! Form::text('title',$title,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-12">
                <div id="edit-form">
                    <textarea id="fb-template">
                        {!! $xml !!}
                    </textarea>
                </div>
                <div id="rendered-form">
                    <form action="#"></form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('FooterInclude')
<!--https://github.com/kevinchappell/formBuilder-->
<script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
<script src="http://formbuilder.online/assets/js/form-render.min.js"></script>
<script>

    jQuery(document).ready(function ($) {
        var fbTemplate = document.getElementById('fb-template'),
                formContainer = document.getElementById('rendered-form'),
                $fBInstance = $(document.getElementById('edit-form')),
                formRenderOpts = {
                    container: $('form', formContainer)
                };

        $(fbTemplate).formBuilder();
        var formBuilder = $(fbTemplate).formBuilder();
        $('.form-builder-save').click(function (e) {
            $fBInstance.toggle();
            $(formContainer).toggle();
            $(fbTemplate).formRender(formRenderOpts);
            e.preventDefault();
            var formData = formBuilder.data('formBuilder').formData;
            var title = $("#title").val();
            $.ajax({
                type: "PATCH",
                url: "{{url('service-desk/form-builder/'.$form->id)}}",
                dataType: "json",
                data: {'form': formData, 'title': title},
                success: function (json) {
                    console.log(json.result);
                    var res = "";
                    $.each(json.result, function (idx, topic) {
                        if (idx === "success") {
                            res = "<div class='alert alert-success'>" + topic + "</div>";
                        }
                        if (idx === "fails") {
                            res = "<div class='alert alert-danger'>" + topic + "</div>";
                        }
                    });

                    $("#response").html(res);
                },
                error: function (json) {
                    var res = "";
                    $.each(json.responseJSON, function (idx, topic) {
                        res += "<li>" + topic + "</li>";
                    });
                    $("#response").html("<div class='alert alert-danger'><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>" + res + "</ul></div>");
                }
            });
        });

        $('.edit-form', formContainer).click(function () {
            $fBInstance.toggle();
            $(formContainer).toggle();
        });
    });
</script>
@stop