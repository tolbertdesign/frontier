<script>
export default {
  name: 'AppNavbarRoutes',
  functional: true,
  render (h, { props }) {
    return props.routes.map(route =>
      <li key={route.name}>
        <router-link class="px-3 py-2 rounded-md text-sm leading-5 font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out" to={route}>
          {route.title}
        </router-link>
      </li>,
    )
  },
}
</script>
