<template>
  <div class="register-container">
    <h1 class="title">ユーザ新規登録画面</h1>
    <div class="form-container">
      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="name">名前:</label>
          <input
            id="name"
            type="text"
            v-model="form.name"
            required
            placeholder="名前"
          />
        </div>
        <div class="form-group">
          <label for="email">メールアドレス:</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            required
            placeholder="メールアドレス"
          />
        </div>
        <div class="form-group">
          <label for="password">パスワード:</label>
          <input
            id="password"
            type="password"
            v-model="form.password"
            required
            placeholder="パスワード"
          />
        </div>
        <div class="form-group">
          <label for="password_confirmation">パスワード確認:</label>
          <input
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            required
            placeholder="パスワード確認"
          />
        </div>
        <div class="button-container">
          <button type="submit" class="submit-btn">登録</button>
          <a href="/login" class="login-btn">ログイン</a>
        </div>
      </form>
    </div>
  </div>
</template>