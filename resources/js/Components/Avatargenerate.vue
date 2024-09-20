<template>
  <div class="avatar" :style="avatarStyles">
    <span class="initials">{{ getInitials(props.person.name) }}</span>
  </div>
</template>
  <script setup>
import { computed } from "vue";

const props = defineProps({
  person: {
    type: Object,
    required: true,
    validator: (value) => value.name && value.employee_type,
  },
});
console.log(props.person.name);
const backgroundColors = {
  Plasterer: "black",
  Admin: "green",

  // Add more employee types and colors as needed
};

// Function to get initials
function getInitials(name) {
  const nameParts = name.trim().split(" ");
  let initials = nameParts
    .slice(0, 2)
    .map((part) => part.charAt(0))
    .join("")
    .toUpperCase();
  return initials;
}

// Computed property to set the background color based on employee_type
const avatarStyles = computed(() => ({
  backgroundColor: backgroundColors[person.employee_type] || "gray", // Default to gray if type is not found
  width: "60px",
  height: "60px",
  borderRadius: "50%",
  display: "flex",
  justifyContent: "center",
  alignItems: "center",
  color: "white",
  fontSize: "24px",
}));
</script>
  <style scoped>
.avatar {
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.initials {
  color: white;
  font-weight: bold;
}
</style>
  