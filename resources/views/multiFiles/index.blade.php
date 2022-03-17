<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            <h2>Multiple File Upload Using Ajax In Laravel 8</h2>
        </div>
        <div class="card-body">
            <form id="ajax-multiple-file-upload" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="files" name="files[]" multiple="">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose Multiple Files</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>image</th>
            <th>name</th>
            <th>path</th>
            <th>action</th>

        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>
<script type="text/javascript">

    $(document).ready(function (e) {
        getData()
        function getData(){
            $.ajax({
                type: "get",
                url: '/getData',
                dataType: 'json',
                success:function (response) {
                    $('tbody').html('');
                    $.each(response.files ,function(key,item) {
                        $('tbody').append(
                            `<tr>
<td>${item.id}</td>
<td><img width="100px" height="100px" class="" alt="64x64" src="/MultiFile/${item.name}"></td>
<td>${item.name}</td>
<td>${item.path}</td>
<td>
  <button type="button" value="${item.id}" href="#"  class="delete-post-btn btn btn-danger">delete</button>
</td>

</tr>`
                        )

                    })
console.log(response.files);


                }
            })
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#ajax-multiple-file-upload').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            let TotalFiles = $('#files')[0].files.length; //Total files
            let files = $('#files')[0];
            for (let i = 0; i < TotalFiles; i++) {
                formData.append('files' + i, files.files[i]);
            }
            formData.append('TotalFiles', TotalFiles);

            $.ajax({
                type:'POST',
                url: "{{ url('ajax-files-upload')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (data) => {
                    this.reset();
                    alert('Multiple File has been uploaded using jQuery ajax');
                    getData()
                },
                error: function(data){
                    alert(data.responseJSON.errors.files[0]);
                }
            });
        });

        $(document).on('click','.delete-post-btn',function (e) {
            e.preventDefault();
            let fileId=$(this).attr("value")
            $.ajax({
                type:'DELETE',
                url:'/deleteFile/'+fileId,
                dataType:'json',
                success:function (response) {
                    console.log(response.success);
                    getData();

                }
            })

        })

    });

</script>
</body>
</html>

