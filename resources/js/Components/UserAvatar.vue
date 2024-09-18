<template>
  <div v-for="user in limitedUsers" :key="user.id">
    <img
      :src="getAvatarUrl(user.avatar)"
      alt="Avatar"
      class="h-8 w-8 rounded-full border-2 border-white hover:ring-white"
      :title="user.name"
    />
  </div>
</template>
  
  <script>
export default {
  props: {
    users: {
      type: Array,
      required: true,
    },
    limit: {
      type: Number,
      default: 5,
    },
  },
  computed: {
    limitedUsers() {
      return this.users.slice(0, this.limit);
    },
  },
  methods: {
    getAvatarUrl(avatar) {
      // Customize this method as per your application's logic to get the avatar URL

      return `${window.location.origin}/${avatar}`;
    },
  },
};
</script>
  
  <style scoped>
/* Add any additional styling if needed */
</style>
  