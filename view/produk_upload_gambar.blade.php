<!-- imageupload.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Upload gambar</title>
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/library/dropzone-5.7.0/dropzone.min.css">
</head>

<body>
    <div class="container">
        <h1>Nama Produk : {{$item->nama_p}}</h1>
        <h3>Kategori : {{$kategori->nama_k}}</h3>
        <form method="post" action="{{url('produk/gambar/upload/store')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="id_p" name="id_p" value="{{$item->id_p}}"><br>
        </form>
        <button onclick="window.location.href = '/home/produk';">Submit</button>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/assets/library/dropzone-5.7.0/dropzone.min.js"></script>
<script>
    Dropzone.options.dropzone = {
        maxFilesize: 5,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 50000,
        removedfile: function(file) {
            var name = file.upload.filename;
            console.log(name);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("produk/gambar/delete") }}',
                data: {
                    filename: name
                },
                success: function(data) {
                    console.log("File has been successfully removed!!");
                },
                error: function(e) {
                    console.log(e);
                }
            });
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },

        success: function(file, response) {
            console.log(response);
        },
        error: function(file, response) {
            return false;
        }
    };
</script>

</html>
