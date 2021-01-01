Updates:

- [ ] Break admin controller with traits
- [ ] Helpers
- [ ] Textyy (github.com/tayyebi/textyy)
- [ ] Allow user to choose between texyy (markup) or simplemde (markdown)


Phase 0:

- [X] Remove types from posts
- [X] Basic Authentication Login
- [X] API Authentication
- [X] Show posts on homepage
- [X] View posts
- [X] People management
- [X] Posts managament
- [X] Markdown editor
- [X] Translate markdown
- [ ] Multi language posts
- [ ] Multi language UI
- [ ] Token authentication
- [ ] Authorization (Return PersonId and role as response)
- [ ] People role management & Define new People
- [ ] Seach on homepage
- [ ] Manage, View and Link Categories
- [ ] Emails and tickets
- [ ] Dashboard Statistics (Hard Disk, Network Traffic, Firewall, Visits)
- [ ] Paginate posts in home page and management
- [ ] Query String Overloading https://github.com/Pressz/Sariab-V2/commit/92daa86b8433f68398c6499733830607ede5982c
- [ ] Two purpose authentication (seperate admins from database users)
- [ ] Seperate admin controller files

Phase 1: Web site features (EMails & Tickets, Form buidler, )

- [ ] Enable to send posts in series with Person defined 'index' and generate single page printable output (Commonly used in books and magazines style)
- [ ] HTTP authentication with different logics enabled (SQL Authentication, OS authentication, etc ...)
- [ ] SEO on Category, Search, View and Home Pages
- [ ] Dynamic routing

Phase 2: Web API features

- [ ] API Versioning (Allow to use different versions of API for Enterprise consumers): how to=> Search for api version, if not exist, use a lower version.
- [ ] Blog feed RSS
- [ ] Form builder
- [ ] Workflow builder

Phase 3:

- [ ] Gordafarid Authentication
- [ ] Federated blog posts
- [ ] Emails between federals

Phase 4:

- [ ] Routing dynamic configuration
- [ ] Android application
- [ ] Desktop application

Phase 5:

- [ ] Code and scaffolding command-line assistant
- [ ] Plugins installation and management


---

From former versions


# UNDER CONSTRUCTION

Steps to pass:

1. Admin must publish sent posts
2. Create and manage forms
3. Send, review and manage answers
4. Manage People, passwords and roles
5. API Level authentication and authorization
6. Forms process management and document forwarding
7. Release as WIKI
8. Implement Circlces
9. Manage Circles for all roles
10. Manage Authorization based on Circles
11. Release as social network

TODO:

86. HANDLE CATEGORIES USING KEYWORDS
11. offline backup
12. Show messages and error pages
13. Version control
16. SEO: Sitemap Generator : https://support.google.com/webmasters/answer/183668?hl=en
17. SEO: Contact info : https://www.w3schools.com/tags/tag_address.asp
18. SEO: Privacy Policy
19. SEO: Terms of Service (TOS)
21. SEO: rel=”canonical”
22. SEO: Microdata
23. SEO: Content type : https://developer.mozilla.org/en-us/docs/Web/Guide/HTML/Content_categories
29. SEO: Twitter card
34. Keywords must be added automatically after detecting hashtags in POST
37. Statistics
39. SEO: Demographics : https://searchengineland.com/connecting-demographics-search-queries-243440
40. SEO: Trending
41. SEO: meta-number for page clicks
42. SEO: Cloaking for Bing and Google
43. SEO: Error 301
50. File System Manager
56. Person profile and activity;
62. Validate anti forgery tokens and create unique forms with isssetPost['UNIQUE VAL']
71. SEO: ui li; Based on Keywords
74. Allow plugins
79. Auto update script to download and unzip last release form Github.com
80. Installation and configuration window
91. Button to decrase database size (remove previous versions)
92. Print option for books
93. Datawarehouse for enterprise usage
95. Handle sql injecttions in post/...
96. Delete keywords on related post delete
97. Export Answers to `.h5` and `.csv`
98. Generate Invoke forms for Controllers same as Microsoft ASMX
    If controller allowed VIEW method
99. Add domains (as publications); human will be able to create his/her own domain and attach their website to this RSS.
