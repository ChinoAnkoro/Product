<!-- resources/js/Pages/Products/Index.vue -->
<template>
  <div>
    <h2>商品一覧画面</h2>
    <button @click="createProduct" v-if="isAuthenticated">新規登録</button>

    <!-- 検索フォーム -->
    <form @submit.prevent="searchProducts">
      <input v-model="searchQuery" type="text" placeholder="商品名で検索">
      <select v-model="selectedMakerId">
        <option value="">メーカー</option>
        <option v-for="maker in makers" :key="maker.id" :value="maker.id">
          {{ maker.name }}
        </option>
      </select>
      <button type="submit">検索</button>
    </form>

    <!-- 商品リストテーブル -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>商品画像</th>
          <th>商品名</th>
          <th>価格</th>
          <th>在庫数</th>
          <th>メーカー名</th>
          <th>アクション</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>
            <img v-if="product.image" :src="`/storage/${product.image}`" alt="Product Image" width="50" height="50"/>
            <span v-else>画像なし</span>
          </td>
          <td>
            <a :href="`/products/${product.id}`">{{ product.product_name }}</a>
          </td>
          <td>{{ product.price }}￥</td>
          <td>{{ product.stock }}</td>
          <td>{{ product.maker.name }}</td>
          <td>
            <button @click="viewProduct(product.id)" v-if="isAuthenticated">詳細</button>
            <button @click="deleteProduct(product.id)" v-if="isAuthenticated">削除</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- ページネーション -->
    <div v-if="pagination">
      <button @click="fetchPage(pagination.prev_page_url)" v-if="pagination.prev_page_url">Previous</button>
      <button @click="fetchPage(pagination.next_page_url)" v-if="pagination.next_page_url">Next</button>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  name: 'Index',
  setup() {
    const products = ref([]);
    const makers = ref([]);
    const searchQuery = ref('');
    const selectedMakerId = ref('');
    const isAuthenticated = ref(false); // 認証状態をここで管理
    const pagination = ref(null);

    // 商品一覧を取得するメソッド
    const fetchProducts = async (page = 1) => {
      try {
        const response = await axios.get(`/api/products?page=${page}`, {
          params: {
            search: searchQuery.value,
            maker_id: selectedMakerId.value,
          },
        });
        products.value = response.data.data;
        pagination.value = response.data.meta;
      } catch (error) {
        console.error(error);
      }
    };

    // 新規登録ページにリダイレクトするメソッド
    const createProduct = () => {
      window.location.href = '/products/create';
    };

    // 詳細ページにリダイレクトするメソッド
    const viewProduct = (id) => {
      window.location.href = `/products/${id}`;
    };

    // 商品を削除するメソッド
    const deleteProduct = async (id) => {
      if (confirm('削除しますか？')) {
        try {
          await axios.delete(`/api/products/${id}`);
          fetchProducts(); // 再度商品リストを取得
        } catch (error) {
          console.error(error);
        }
      }
    };

    // 検索フォームの送信
    const searchProducts = () => {
      fetchProducts();
    };

    // 初期データを取得
    fetchProducts();

    return {
      products,
      makers,
      searchQuery,
      selectedMakerId,
      isAuthenticated,
      pagination,
      fetchProducts,
      createProduct,
      viewProduct,
      deleteProduct,
      searchProducts,
    };
  },
};
</script>