# This is database structure API
```js
baseUrl: 'dev.socialnetwork.api.com/api'
```
## User
### API: 
```js  
    '/get_users'
```
### Info:
if api don't have object
```js 
{ params: {
    user_url: this.$store.params.url
  }
}
```
=> return null array []
For each param user_url, response.data.data return to Array [{user}] , to use this:
```js
this.paramUser[0]
```

## Post
API: 
```js
'/get_posts'
```
Info:
Object params like:
```js
{ params: {
    user_id: this.$store.params.user_id,
    post_id: this.$store.params.post_id,
    search_key: this.searchKey,
    sort: this.sortType,
    visible: this.visible
  }
}
```
if params has only user_id => return where posts.user_id
if params has only post_id => return where posts.id
if params has user_id and post_id => return []
if params has visible => return where posts.visible
  if visible = public => get
  if visible = friend => check friend (in develop)
  if visible = private => check auth()->user()->id, this post can edit
  if visible = blocked => this post can't edit, but till visible

### Comment
#### SubComment

### Like

## Message