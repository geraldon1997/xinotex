<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>[site_title]</title>
  <style>
  .container{
    width : 100%;
  }
  .card{
    width: 100%;
    height: auto;
  }
  .card-head{
    background-color: grey;
    padding: 20px;
    border-top-left-radius: 7.5px;
    border-top-right-radius: 7.5px;
    color: white;
  }
  .card-body{
    padding: 10px;
  }
  .card-body h2{
    text-transform: capitalize;
  }
  .card-footer{
    background-color: lightgray;
    padding: 10px;
    border-bottom-left-radius: 7.5px;
    border-bottom-right-radius: 7.5px;
  }
  .btn{
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
    background-color: blue;
    color: white !important;
    font-weight: bold;
  }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-head">
      <b>[site_title]</b>
      </div>
      <div class="card-body">
      <h2>[caption]</h2>
      <p>Hi [email],</p>
      <p>[body]</p>
      </div>
      <div class="card-footer">
      <b>- [site_title]</b>
      </div>
    </div>
  </div>
</body>
</html>