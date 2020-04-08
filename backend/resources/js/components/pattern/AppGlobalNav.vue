<template>
  <nav
    class="navbar is-dark"
    role="navigation"
    aria-label="main navigation"
  >
    <div class="navbar-brand">
      <a
        class="navbar-item"
        href="/"
      >
        Global Navigation
      </a>

      <a
        id="admin-slideout-button"
        role="button"
        class="navbar-item is-hidden-desktop"
      >
        <span class="icon">
          <FontAwesomeIcon :icon="['far', 'arrow-circle-right']" />
        </span>
      </a>

      <a
        role="button"
        class="navbar-burger burger"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbarMain"
        @click="isActive = !isActive"
      >
        <span aria-hidden="true" />
        <span aria-hidden="true" />
        <span aria-hidden="true" />
      </a>
    </div>

    <div
      id="navbarMain"
      class="navbar-menu"
    >
      <div class="navbar-start" /><!-- end of .navbar-start -->

      <div
        class="navbar-end nav-menu"
        style="overflow: visible"
      />
    </div>
  </nav>
</template>
