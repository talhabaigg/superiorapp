// src/helpers/colorHelpers.js

export const getColorByEmployeeType  = (employeeType) => {
    const colors = {
      "Back office": "#57544f",
      Plasterer: "#17a34a",
      Foreman: "#17a34a",
      "Leading Hand": "#2563ea",
      Painter: "green",
      "Site Manager": "orange",
      Laborer: "gray",
      // Add more employee types and their corresponding colors here
    };
  
    return colors[employeeType] || "pink"; // Default color if type not found
  };
  