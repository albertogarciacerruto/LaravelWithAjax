<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <!-- JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <div class="row justify-content-center align-items-center minh-100">
            <div class="col-md-6">
                <br>
                <h2>Gestor de Tareas</h2>
                <hr style="width:100%;">
                <form id="formHomework" method="POST">
                @csrf
                    <input id="categories" type="hidden" name="n=categories">
                    <div class="form-group">
                        <label>Tarea:</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autofocus>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <input type="checkbox" name="skills[]" value="PHP">PHP</br>
                    <input type="checkbox" name="skills[]" value="CSS">CSS</br>
                    <input type="checkbox" name="skills[]" value="JavaScript">JavaScript</br>
                    <br>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </form>
                
            </div>
        </div>
        <div class="row justify-content-center align-items-center minh-100">
            <div id="sectionLists" class="col-md-6">
                <br>
                <div id="lista">
                    <table id="dataTable" class="table">
                        <thead>
                            <tr>
                            <th scope="col">Tarea</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_items as $item)
                            <tr data-id="{{$item->id}}">
                                <td>{{ $item->name }}</td>
                                <td>
                                {{ $item->category }}
                                </td>
                                <td>
                                <button class="btn btn-primary btn-action">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $(document).ready(function(){
        $('.btn-action').click(function(e){
            e.preventDefault();
            var token = '{{csrf_token()}}';
            var row = $(this).parents('tr');
            var id = row.data('id').toString();
            var url = "{{ url('items_destroy') }}";
            var data={_token:token, id: id};
            $.ajax({
                type:"GET",
                url: url,
                data: data,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    location.reload();
                }
            });  
        });
    });

    function checkRemesas() {
        var ids = '';
        $("input:checkbox:checked").each(function () {
            var selected = '';
            selected = $(this).val().trim();
            if (selected !== "on") {
                if (ids === '')
                    ids += selected;
                else
                    ids += ',' + selected ;
            }
            document.getElementById('categories').value = ids;

        });
    }


    $('#formHomework').on('submit', function(e) {
        checkRemesas();
        e.preventDefault(); 
        var skills = document.getElementById('categories').value;
        var name = $('#name').val();
        $.ajax({
            type: "POST",
            url: "{{ url('register') }}",
            data: {name:name, skills:skills},
            success: function(data) {
                location.reload();
            }
        });
    });
</script>
