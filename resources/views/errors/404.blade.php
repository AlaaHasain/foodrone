@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #000;
    color: white;
    overflow: hidden;
  }

  .game-container {
    position: relative;
    width: 100%;
    height: 90vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
  }

  h1 {
    font-size: 100px;
    color: #ffbe33;
    margin: 0;
    font-weight: 800;
  }

  p {
    font-size: 18px;
    margin-bottom: 20px;
    color: #ccc;
  }

  canvas {
    background: linear-gradient(to bottom, #222831, #000);
    border: 2px solid #ffbe33;
    border-radius: 10px;
  }

  #restart-btn {
    display: none;
    margin-top: 20px;
    padding: 10px 25px;
    background-color: #ffbe33;
    border: none;
    border-radius: 25px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    font-size: 16px;
  }

  #restart-btn:hover {
    background-color: #e69c00;
  }

  .info-bar {
    display: flex;
    justify-content: space-between;
    width: 400px;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 16px;
    color: #ffbe33;
  }

  .fire {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 100px;
    height: 100px;
    transform: translateX(-50%);
    background: url("{{ asset('images/fire.gif') }}") no-repeat center center / contain;
    display: none;
    pointer-events: none;
  }
</style>

<div class="game-container">
  <h1>404</h1>
  <p>Oops! This page doesn't exist. While we fix it, enjoy this mini-game!</p>

  <div class="info-bar">
    <div id="scoreDisplay">Score: 0</div>
    <div id="countdown">Returning in 20s</div>
  </div>

  <canvas id="gameCanvas" width="400" height="300"></canvas>
  <div class="fire" id="fireEffect"></div>
  <button id="restart-btn" onclick="restartGame()">Restart Game</button>

  <!-- أصوات -->
  <audio id="failSound" src="{{ asset('sounds/fail.mp3') }}" preload="auto"></audio>
  <audio id="jumpSound" src="{{ asset('sounds/jump.mp3') }}" preload="auto"></audio>
  <audio id="bgMusic" src="{{ asset('sounds/background.mp3') }}" preload="auto" loop></audio>
</div>

<script>
  const canvas = document.getElementById("gameCanvas");
  const ctx = canvas.getContext("2d");
  const player = { x: 50, y: 230, width: 30, height: 30, velocityY: 0, jumping: false };
  const obstacle = { x: 400, y: 230, width: 30, height: 30 };
  const gravity = 1;
  const jumpForce = -15;

  let gameOver = false;
  let countdown = 20;
  let score = 0;
  let speed = 5;
  let timeElapsed = 0;
  let intervalId;

  const fireEffect = document.getElementById("fireEffect");
  const scoreDisplay = document.getElementById("scoreDisplay");
  const countdownDiv = document.getElementById("countdown");
  const restartBtn = document.getElementById("restart-btn");

  const failSound = document.getElementById("failSound");
  const jumpSound = document.getElementById("jumpSound");
  const bgMusic = document.getElementById("bgMusic");

  function drawPlayer() {
    ctx.fillStyle = "#ffbe33";
    ctx.fillRect(player.x, player.y, player.width, player.height);
  }

  function drawObstacle() {
    ctx.fillStyle = "#dc3545";
    ctx.fillRect(obstacle.x, obstacle.y, obstacle.width, obstacle.height);
  }

  function update() {
    if (gameOver) return;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    player.velocityY += gravity;
    player.y += player.velocityY;

    if (player.y >= 230) {
      player.y = 230;
      player.jumping = false;
    }

    obstacle.x -= speed;
    if (obstacle.x < -30) {
      obstacle.x = 400 + Math.random() * 200;
      score += 10;
      scoreDisplay.textContent = `Score: ${score}`;
    }

    // تصادم
    if (
      player.x < obstacle.x + obstacle.width &&
      player.x + player.width > obstacle.x &&
      player.y < obstacle.y + obstacle.height &&
      player.y + player.height > obstacle.y
    ) {
      endGame();
    }

    drawPlayer();
    drawObstacle();
  }

  function gameLoop() {
    update();
    if (!gameOver) requestAnimationFrame(gameLoop);
  }

  function handleKeyDown(e) {
    if (e.code === "Space" && !player.jumping && !gameOver) {
      player.velocityY = jumpForce;
      player.jumping = true;
      jumpSound.play();
    }
  }

  function endGame() {
    gameOver = true;
    failSound.play();
    bgMusic.pause();
    fireEffect.style.display = "block";
    restartBtn.style.display = "inline-block";
  }

  function restartGame() {
    player.y = 230;
    player.velocityY = 0;
    obstacle.x = 400;
    player.jumping = false;
    gameOver = false;
    score = 0;
    speed = 5;
    countdown = 20;
    timeElapsed = 0;

    scoreDisplay.textContent = `Score: 0`;
    countdownDiv.textContent = `Returning in 20s`;
    fireEffect.style.display = "none";
    restartBtn.style.display = "none";

    bgMusic.currentTime = 0;
    bgMusic.play();

    gameLoop();

    clearInterval(intervalId);
    startCountdown();
  }

  function startCountdown() {
    intervalId = setInterval(() => {
      if (!gameOver) {
        countdown--;
        timeElapsed++;

        if (timeElapsed % 5 === 0) speed += 1;

        countdownDiv.textContent = `Returning in ${countdown}s`;

        if (countdown <= 0) {
          clearInterval(intervalId);
          window.location.href = "{{ route('home') }}";
        }
      }
    }, 1000);
  }

  document.addEventListener("keydown", handleKeyDown);
  document.addEventListener("click", () => {
    if (bgMusic.paused) {
      bgMusic.volume = 0.3;
      bgMusic.play().catch(() => {});
    }
  }, { once: true });

  // Start
  gameLoop();
  startCountdown();
</script>
@endsection
