module.exports = {
  host: '0.0.0.0',
  port: '8081',
  base: '/frontier/',
  title: 'Knowledge Base',
  description: 'A knowledge base is a self-serve online library of information about a product, service, department, or topic. The data in your knowledge base can come from anywhere. Typically, contributors who are well versed in the relevant subjects add to and expand the knowledge base.',
  head: [
    ['link', { rel: 'icon', href: '/logo.png' }]
  ],
  themeConfig: {
    // logo: '/assets/img/logo.png',
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/' },
      { text: 'Demo App', link: 'https://app.tolbert.design' },
      {
        text: 'Languages',
        ariaLabel: 'Language Menu',
        items: [
          { text: 'Chinese', link: '/language/chinese/' },
          { text: 'Japanese', link: '/language/japanese/' }
        ]
      }
    ],
    sidebar: []
  },
  configureWebpack: {
    resolve: {
      alias: {
        '@alias': 'path/to/some/dir'
      }
    }
  },
  markdown: {
    lineNumbers: true,
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
