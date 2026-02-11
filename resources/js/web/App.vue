<script>
import { h } from 'vue';

export default {
  name: 'App',
  render() {
    // Render a minimal wrapper - the actual content will be restored after mount
    return h('div', { class: 'flex min-h-screen flex-col' });
  }
}
</script>
