<a href="#asset" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#asset{{$id}}">Attach Asset</a>
<div class="modal fade" id="asset{{$id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Assets</h4>
            </div>
            <div class="modal-body">
                <!-- Form  -->


                <p>This example shows how to use Tagit on an input!</p>
                <input type="text" id="text" name="tags" value=""/>
                <br/>
                <input type="button" id="submitTags" value="Value"/>
                <br/>
                <div id="tagName"/>

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('lang.save')}}">
            </div>

            {!! Form::close() !!}
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  
@section('FooterInclude')
<?php
$url = app('url')->asset('../app/Plugins/ServiceDesk/public/tag');
?>
<script src="{{$url}}/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link href="{{$url}}/css/jquery.tagit.css" rel="stylesheet" type="text/css">
<!-- https://github.com/aehlke/tag-it -->
<script>
function submit(value) {
    $("#submitTags").click(function () {
        $("#text").tagit("createTag", value);
        $("#tagName").html('The value is :: ' + $("input#text").val());
    });
}
$(document).ready(function () {
    var input = $("input#text");



    //The tagit list
    var instance = $("<ul class=\"tags\"></ul>");

    //Store the current tags
    //Note: the tags here can be split by any of the trigger keys
    //      as tagit will split on the trigger keys anything passed  
    var currentTags = input.val();

    //Hide the input and append tagit to the dom
    input.hide().after(instance);

    input.tagit({
        singleField: true,
        singleFieldNode: $('#assets'),
        autocomplete: ({
            source: function (request, response) {
                $.ajax({
                    url: "{{url('service-desk/assets/tag')}}",
                    data: {format: "json", query: request.term},
                    dataType: 'json',
                    type: 'GET',
                    success: function (data) {
                        response($.map(data, function (item) {
                            console.log(item);
                            return {
                                label: item.label,
                                value: item.label
                            };
                            submit(item.value);
                        }));
                    },
                    error: function (request, status, error) {
                        console.log(error);
                    }
                });
            },
            minLength: 1
        }),
        tagsChanged: function () {
            //Get the tags            
            var tags = instance.tagit('tags');
            var tagString = [];

            //Pull out only value
            for (var i in tags) {
                tagString.push(tags[i].value);
            }

            //Put the tags into the input, joint by a ','
            input.val(tagString.join(','));
        }


    });
//    
});
</script>
@stop