<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memberships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
	<div></div>
    <h2 class="text-center mt-5">Memberships</h2>
	<div class="col-md-6 offset-md-3" style="margin-top: 5rem">
		<div class="card-group gap-2">
			<div class="card rounded-1">
				<img src="{{ asset("img/membership/logos/1.jpeg") }}" class="card-img-top">
				<div class="card-body bg-primary">
				<h5 class="card-title text-center fw-bolder text-white">Plan Básico</h5>
				<h6 class="card-subtitle mb-2 text-white text-center">Costo: $10.000</h6>
				<ul class="list-group list-group-flush">
					<li class="list-group-item bg-primary text-white fw-bolder">1 Cartera</li>
					<li class="list-group-item bg-primary text-white fw-bolder">Soporte Técnico</li>
					<li class="list-group-item bg-primary text-white fw-bolder">Acceso Completo</li>
				</ul>
				<p class="card-text"><button class="btn btn-outline-light form-control" onclick="document.querySelectorAll('.waybox-button')[0].click()">Buy</button></p>
				</div>
			</div>
			<div class="card rounded-1">
				<img src="{{ asset("img/membership/logos/2.jpeg") }}" class="card-img-top">
				<div class="card-body bg-warning">
				<h5 class="card-title text-center fw-bolder text-white">Plan Avanzado</h5>
				<h6 class="card-subtitle mb-2 text-center text-white">Costo: $15.000</h6>
				<ul class="list-group list-group-flush ">
					<li class="list-group-item bg-warning text-white fw-bolder">3 Carteras</li>
					<li class="list-group-item bg-warning text-white fw-bolder">Soporte Técnico</li>
					<li class="list-group-item bg-warning text-white fw-bolder">Acceso Completo</li>
				</ul>
				<p class="card-text"><button class="btn btn-outline-light form-control">Buy</button></p>
				</div>
			</div>
			<div class="card rounded-1">
				<img src="{{ asset("img/membership/logos/3.jpeg") }}" class="card-img-top">
				<div class="card-body bg-success">
				<h5 class="card-title text-center fw-bolder text-white">Plan Premium</h5>
				<h6 class="card-subtitle mb-2 text-white text-center">Costo: $25.000</h6>
				<ul class="list-group list-group-flush">
					<li class="list-group-item bg-success text-white fw-bolder">+5 Carteras</li>
					<li class="list-group-item bg-success text-white fw-bolder">Soporte Técnico</li>
					<li class="list-group-item bg-success text-white fw-bolder">Acceso Completo</li>
				</ul >
				<p class="card-text"><button class="btn btn btn-outline-light form-control">Buy</button></p>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none;">
		<form>
			<script
				src="https://checkout.wompi.co/widget.js"
				data-render="button"
				data-public-key="{{ $publicKey }}"
				data-currency="{{ $currency }}"
				data-amount-in-cents="{{ $amountInCents }}"
				data-reference="{{ $reference }}"
				data-signature:integrity="{{ $signature }}"
			></script>
		</form>
	</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>