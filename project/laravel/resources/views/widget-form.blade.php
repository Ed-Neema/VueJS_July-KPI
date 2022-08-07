<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enquiry Manager - Widget Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .submit-success{
            color: #41b64c;
            margin-top: 10px;
            display: none;
        }
        .submit-error{
            color: #b64141;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>

    <div class="container mt-10">
        <form id="widgetForm" action="{{ url('api/enquiry/submit/'.$form_id.'/'.$source_id) }}">
            @foreach($field_data as $field)
                @switch($field['type'])
                    @case(0)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <input type="text" class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}">
                    </div>
                    @break

                    @case(1)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <textarea class="form-control" id="{{ $field['name'] }}" rows="3" name="{{ $field['name'] }}"></textarea>
                    </div>
                    @break

                    @case(2)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <select class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}">
                            <option value="">- Select -</option>
                            @foreach(json_decode($field['field_data']) as $field_data)
                                <option value="{{ $field_data->value }}">{{ $field_data->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    @break

                    @case(3)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        @foreach(json_decode($field['field_data']) as $field_data)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $field_data->value }}">
                                <span for="exampleRadios1">{{ $field_data->value }}</span>
                            </div>
                        @endforeach
                    </div>
                    @break

                    @case(4)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        @foreach(json_decode($field['field_data']) as $field_data)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $field_data->value }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}">
                                <span for="{{ $field['name'] }}-{{ $field_data->id }}">{{ $field_data->value }}</span>
                            </div>
                        @endforeach
                    </div>
                    @break

                @endswitch

            @endforeach
            <button type="submit" class="btn btn-primary btn-submit">Submit</button>
        </form>

        <div id="formAlert"></div>
    </div>

    <script>
        $("#widgetForm").submit(function(e) {
            e.preventDefault();
            $(".btn-submit").text('Submitting...').attr("disabled", true);

            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serializeArray();
            var formDataArray = {};

            $.map(formData, function(n, i){
                formDataArray[n['name']] = n['value'];
            });

            $("#formAlert").attr('class', '').hide();

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: {
                    'data': JSON.stringify(formDataArray)
                },
                success: function()
                {
                    $("#formAlert").html("<strong>Success!</strong> Form submitted successfully.");
                    $("#formAlert").addClass('submit-success').show();
                },
                error: function(data)
                {
                    var err = JSON.parse(data.responseText);
                    if ($.isArray(err.message)) {
                        var messageText = '';
                        $.each( err.message, function( key, value ) {
                            messageText = messageText + '<span>'+value+'</span></br>';
                        });

                        $("#formAlert").html("<strong>Error!</strong></br>"+ messageText +"");
                    } else {
                        $("#formAlert").html("<strong>Error!</strong></br>"+ err.message +"");
                    }

                    $("#formAlert").addClass('submit-error').show();
                },
                complete: function() {
                    $(".btn-submit").text('Submit').removeAttr("disabled");
                }
            });

        });
    </script>
</body>
</html>
