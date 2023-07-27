<template>
  <div class="container">
    <div class="error-message">
      <h1>404</h1>
      <p>Oops! Page not found.</p>
    </div>
  </div>
</template>

<script lang="ts"></script>

<style scoped>
body {
  background: #f5f5f5;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.error-message {
  text-align: center;
}

.error-message h1 {
  font-size: 10rem;
  margin: 0;
  color: #3e3e40;
}

.error-message p {
  font-size: 1.5rem;
  margin: 0;
  color: #777777;
}
</style>
