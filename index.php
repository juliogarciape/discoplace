<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Descubre la ubicación de una fotografía &#x1F914; | DiscoPlace</title>
</head>
<body>

    <nav class="navbar navbar-dark bg-primary p-2 mb-5">
        <div class="container-fluid">
            <span class="mx-auto navbar-brand mb-0 fs-3 fw-bold">DiscoPlace</span>
        </div>
    </nav>

    <div class="container border p-4 shadow-sm">
    <form id="form" enctype="multipart/form-data" method="POST">
        <div class="mb-4 mx-auto d-grid col-9">
            <label for="formFile" class="form-label fw-bold fs-4 text-center mb-4">Descubre la ubicación donde fue tomada una fotografía &#x1F4F7;</label>
            <input name="photo" class="form-control" id="formFile" type="file" required accept=".jpg, .jpeg">
        </div>
        <div class="d-grid mx-auto col-6">
            <button type="submit" class="btn btn-lg btn btn-warning">Examinar Ubicación &#128373;&#65039;&#8205;&#9794;&#65039;</button>
        </div>
    </form>
    </div>

    <div class="container mt-5 mb-4">
        <div id="response" class="container-fluid"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js" async defer></script>
    <script type="text/javascript">
    
    $(document).ready(function(){
        console.log("Hey guy!!");

        $("#form").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: "search.php",
                data: new FormData(this),
                contentType: false,
                processData: false,
                type: "POST",
                success: function(res){
                
                try{
                    
                    const resJson = JSON.parse(res);
                    if (!resJson.status){
                        alert(resJson.message);
                        return;
                    }

                    const divResponse = document.getElementById('response');
                    divResponse.style.height = "20rem";
                    var mapParameters = { center: {lat: resJson.lat, lng: resJson.lon}, zoom: 18 };
                    var map = new google.maps.Map(divResponse,mapParameters);
                    var flag = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                    var position = { position: {lat: resJson.lat, lng: resJson.lon}, map: map, icon: flag, title: "La fotografía fue tomada aquí"};
                    var marker = new google.maps.Marker(position);

                    function markerClicked(){ 
                        info.setContent(this.getTitle()); 
                        info.open(map, this);
                    }
                    
                    var info = new google.maps.InfoWindow();
                    marker.addListener('click', markerClicked);

                }catch(err){
                    console.error(err);
                    alert("Error al procesar la imagen");
                }}
            });
        });
    });

    </script>
</body>
</html>