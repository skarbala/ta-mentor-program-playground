<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Fellowship of the ring</title>
  <link rel="stylesheet" href="fellowship/style.css">
  <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Bitter|Cinzel:900" rel="stylesheet">
</head>

<body>
<?php include 'partials/navbar.php' ?>

<div id="app" class="container">
  <div class="row title-container">
    <h1 class="title col-md-10">Select your fellows</h1>
    <div class="points-left col-md-2 box-shadow">
      <div v-if=pointsLeft!=0>
        <p>Points left</p>
        <h2>{{pointsLeft}}</h2>
      </div>
      <div v-else>
        <p>Fellowship</p>
        <h3>Complete</h3>
      </div>
    </div>
  </div>
  <ul class="row list-of-fellows">
    <li v-for="fellow in fellows" v-on:click="clickOne(fellow)" class="col-md-4">
      <div class="inner box-shadow" :class="{active:selectedFellows.includes(fellow)}">
        <div class="row">
          <div class="col">
            <h1>{{fellow.name}}</h1>
            <h2>Race: {{fellow.race}}</h2>
            <h2>Age: {{fellow.age}}</h2>
          </div>
          <div class="fellow-points col justify-content-end">
            <h2>{{fellow.score}}</h2>
            <p>points</p>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="fellowship/index.js"></script>

</html>