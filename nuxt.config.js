module.exports = {
  mode: 'spa',
  head: {
    title: 'Misfit',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
			{ hid: 'description', name: 'description', content: 'Misfit' },
			{ name: 'title', property: 'og:title', content: 'AJ Leon' },
			{ name: 'image', property: 'og:image', content: '/images/mobile_frame-1.jpg' },
			{ name: 'description', property: 'og:description', content: 'I nomad around the world and make things happen.' },
			{ name: 'url', property: 'og:url', content: 'https://misfit.co/' }
    ],
    link: [
			{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
			{
				rel: 'stylesheet',
				href: 'https://use.fontawesome.com/releases/v5.7.2/css/all.css',
				integrity: 'sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr',
				crossorigin: 'anonymous'
			}
		],
		// script: [
		// 	{
		// 		src: '~assets/js/jquery.min.js',
		// 		type: "text/javascript",
		// 		defer: 'true',
		// 		body: true
		// 	},
		// 	{
		// 		src: '~assets/js/scripts.js',
		// 		type: "text/javascript",
		// 		defer: 'true',
		// 		body: true
		// 	}
		// ],
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#fff' },
  /*
  ** Global CSS
  */
  css: [
		'@/assets/scss/style.scss'
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
		// { src: '@/plugins/scripts.js' }
		{ src: '~plugins/jquery.min.js', ssr: false },
		{ src: '~plugins/scripts.js', ssr: false }
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
		['@nuxtjs/google-tag-manager', { id: 'UA-134694881-1'}]
  ],
  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
    }
	}
}
