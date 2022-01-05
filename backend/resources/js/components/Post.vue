<template>
  <div class="photo">
    <figure class="photo__wrapper">
      <p>{{item.work_type}}</p>
      <p>{{item.room_name}}</p>
      <p>{{item.start}}</p>
      <p>{{item.end}}</p>
      <p>{{item.owner.name}}</p>
    </figure>
    <RouterLink
      class="photo__overlay"
      :to="`/posts/${item.id}`"
    >
      <div class="photo__controls">
        <button
          class="photo__action photo__action--like"
          title="Like post"
        >
          <i class="icon icon-md-heart"></i>12
        </button>
      </div>
    </RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}
</script>
