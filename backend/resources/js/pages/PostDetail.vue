<template>
  <div v-if="post" class="photo-detail">
    <figure class="photo-detail__pane photo-detail__image">
      <p>{{post.work_type}}</p>
      <p>{{post.room_name}}</p>
      <p>{{post.start}}</p>
      <p>{{post.end}}</p>
      <p>{{post.owner.name}}</p>
    </figure>
    <div class="photo-detail__pane">
      <button class="button button--like" title="Like Post">
        <i class="icon icon-md-heart"></i>12
      </button>
      <h2 class="photo-detail__title">
        <i class="icon icon-md-chatboxes"></i>Comments
      </h2>
      <ul v-if="post.comments.length > 0" class="photo-detail__comments">
        <li
          v-for="comment in post.comments"
          :key="comment.content"
          class="photo-detail__comments"
        >
          <p class="photo-detail__commentBody">
            {{ comment.content }}
          </p>
          <p class="photo-detail__commentInfo">
            {{ comment.author.name }}
          </p>
        </li>
      </ul>
      <p v-else>コメントはまだ投稿されていません</p>
      <form v-if="isLogin" @submit.prevent="addComment" class="form">
        <div v-if="commentErrors" class="errors">
          <ul v-if="commentErrors.content">
            <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <textarea class="form__item" v-model="commentContent"></textarea>
        <div class="form__button">
          <button type="submit" class="button button--inverse">コメントを送信する</button>
        </div>
      </form>
    </div>
  </div>
</template>


<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

export default {
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    }
  },
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      post: null,
      commentContent: '',
      commentErrors: null
    }
  },
  methods: {
    async fetchPost () {
      const response = await axios.get(`/api/posts/${this.id}`)
      console.log(response.data);

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.post = response.data
    },
    async addComment () {
      const response = await axios.post(`/api/posts/${this.id}/comments`, {
        content: this.commentContent
      })

      // バリデーションエラー
      if (response.status === UNPROCESSABLE_ENTITY) {
        this.commentErrors = response.data.errors
        return false
      }

      this.commentContent = ''
      // エラーメッセージをクリア
      this.commentErrors = null

      // その他のエラー
      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.post.comments = [
        response.data,
        ...this.post.comments
      ]
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchPost()
      },
      immediate: true
    }
  }
}
</script>
