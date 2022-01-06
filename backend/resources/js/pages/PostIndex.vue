<template>
  <div class="photo-list">
    <div class="grid">
      <Post
        class="grid__item"
        v-for="post in posts"
        :key="post.id"
        :item="post"
      />
    </div>
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </div>
</template>

<script>
import { OK } from '../util'
import Post from '../components/Post.vue'
import Pagination from "../components/Pagination";

export default {
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  components: {
    Post,
    Pagination
  },
  data() {
    return {
      posts: [],
      currentPage: 0,
      lastPage: 0
    }
  },
  methods: {
    async fetchPosts () {
      const response = await axios.get(`/api/posts/?page=${this.page}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.posts = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchPosts()
      },
      immediate: true
    }
  }
}
</script>
