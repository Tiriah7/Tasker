document.querySelectorAll('.status-form select').forEach(sel => {
  sel.addEventListener('change', () => {
    sel.closest('form').submit();
  });
});
