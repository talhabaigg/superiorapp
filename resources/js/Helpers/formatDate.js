//Format date from 22-06-2024 to Jun 22

import { parse, format } from 'date-fns';

export function formatDate(dateString) {
  // Parse the date string into a Date object
  const date = parse(dateString, 'dd-MM-yyyy', new Date());
  
  // Format the date into "MMM dd" (e.g., "Jun 22")
  return format(date, 'MMM dd');
}
