// const currentDateUTC = new Date().toUTCString()

module.exports = {
  host: '0.0.0.0',
  port: '8081',
  base: '/',
  title: 'Frontier',
  description: 'A knowledge base is a self-serve online library of information about a product, service, department, or topic. The data in your knowledge base can come from anywhere. Typically, contributors who are well versed in the relevant subjects add to and expand the knowledge base.',
  head: [
    ['link', { rel: 'icon', href: '/logo.png' }]
  ],
  themeConfig: {
    version: '0.1.0-beta',
    // logo: 'http://cominex.net/assets/booster/img/booster_tag.png',
    repo: 'https://github.com/Boosterthon/frontier/tree/vue-cli/base',
    repoLabel: 'Repo',
    nav: [
      // { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/' },
    // { text: 'Blog', link: '/blog/' },
      // { text: 'Archive', link: '/archive/' },
      // { text: 'RSS Feed', link: '/rss.xml' },
      // {
      //   text: 'Ecosystem',
      //   ariaLabel: 'Backend Menu',
      //   items: [
      //     { text: 'Laravel Horizon', link: 'https://tolbert.design/horizon' },
      //     { text: 'Laravel Nova', link: 'https://tolbert.design/nova' },
      //     { text: 'Laravel Telescope', link: 'https://tolbert.design/telescope' },
      //     { text: 'phpMyAdmin', link: 'https://tolbert.design/nova/dashboards/main' },
      //   ]
      // },
      {
        text: 'Components',
        ariaLabel: 'Components Menu',
        items: [
          {
            text: 'App',
            items: [
              {
                text: 'AppContainer',
                link: '/components/app/container'
              },
              {
                text: 'AppCookieConsent',
                link: '/components/app/cookie-consent'
              },
            ]
          },
          {
            text: 'Layout',
            items: [
              {
                text: 'DefaultLayout',
                link: '/components/layouts/default'
              },
              {
                text: 'FullScreenLayout',
                link: '/components/layouts/full-screen'
              },
              {
                text: 'SidebarLayout',
                link: '/components/layouts/sidebar'
              },
            ]
          },
          {
            text: 'Base',
            items: [
              {
                text: 'Avatar',
                link: '/components/base/avatar'
              },
              {
                text: 'AvatarGroup',
                link: '/components/base/avatar-group'
              },
              {
                text: 'Button',
                link: '/components/base/button'
              },
            ]
          },
          {
            text: 'Templates',
            items: [
              {
                text: 'EasyEmailerPage',
                link: '/components/templates/easy-emailer'
              },
              {
                text: 'EditParticipantPage',
                link: '/components/templates/edit-participant'
              },
              {
                text: 'EditProfilePage',
                link: '/components/templates/edit-profile'
              },
              {
                text: 'HowToGetPledges',
                link: '/components/templates/how-to-get-pledges'
              },
              {
                text: 'SchoolGoalsAndStats',
                link: '/components/templates/school-goals-and-stats'
              },
            ]
          },
        ]
      },
      { text: 'Demo App', link: 'https://app.tolbert.design' },
    ],
    sidebar: [],
    pageSize: 5,
    startPage: 0
  },
  // plugins: [
  //   [
  //     '@vuepress/google-analytics',
  //     {
  //       ga: '' // UA-00000000-0
  //     }
  //   ],
  //   [
  //     'vuepress-plugin-rss',
  //     {
  //       base_url: '/',
  //       site_url: 'https://tolbert.design',
  //       filter: frontmatter => frontmatter.date <= new Date(currentDateUTC),
  //       count: 20
  //     }
  //   ],
  //   'vuepress-plugin-reading-time',
  //   'vuepress-plugin-janitor'
  // ],
  configureWebpack: {
    resolve: {
      alias: {
        '@alias': 'path/to/some/dir'
      }
    }
  },
  markdown: {
    lineNumbers: false,
    extendMarkdown: md => {
      // use more markdown-it plugins!
      md.use(
        require('markdown-it-html5-embed'), {
          html5embed: {
          useImageSyntax: true, // Enables video/audio embed with ![]() syntax (default)
          useLinkSyntax: true   // Enables video/audio embed with []() syntax
        }
        },
      )
    }
  }
}
