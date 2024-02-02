<?php
include ("./includes/header.includes.php");
?>

<head>
<style>
  /* Style voor achtergrond- en tekstkleur */
    .card {
      background-color: #fff;
    }
    .btn-primary {
      width: 250px;
    }
    .mainbuttons {
      border-radius: 100px!important;
      background-color: #043a74;
    }
</style>
</head>
<main class="mt-3">
<div class="container mt-5">
  <div class="row justify-content-center">
    <!-- Eerste Kolom -->
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body d-flex flex-column align-items-left">
          <h5 class="card-title">Ritten</h5>
          <h6>het rit overzicht<br/></h6>
          <button class="btn btn-primary mainbuttons"><a href="#destination1" class="text-white">Ga naar ritten</a></button>
        </div>
      </div>
      
      <div class="card">
        <div class="card-body d-flex flex-column align-items-left">
          <h5 class="card-title">Voorraad beheer</h5>
          <h6>Het voorraad beheer<br/></h6>
          <button class="btn btn-primary mainbuttons"><a href="#destination2" class="text-white">Ga naar voorraad beheer</a></button>
        </div>
      </div>
    </div>

    <!-- Tweede Kolom -->
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body d-flex flex-column align-items-left">
          <h5 class="card-title">Kledingstukken</h5>
          <h6>Alle kledingstukken<br/></h6>
          <button class="btn btn-primary mainbuttons"><a href="#destination3" class="text-white">Ga naar kledingstukken</a></button>
        </div>
      </div>
      
      <div class="card">
        <div class="card-body d-flex flex-column align-items-left">
          <h5 class="card-title">Klanten</h5>
          <h6>Klantenoverzicht<br/></h6>
          <button class="btn btn-primary mainbuttons"><a href="#destination4" class="text-white">Ga naar klanten</a></button>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
