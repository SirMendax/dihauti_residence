# Dihauti Residence

API documentation for the Dihauti Residence web-site.

**Info**
- VERSION: v0.1
- STATUS: testing and revision
- DEVELOPER: Telegin K.I.
- CONTACT: dev.arven@gmail.com

**Links**
- [dihauti.ru](https://dihauti.ru).
- [api.dihauti.ru/api/documentation](https://api.dihauti.ru/api/documentation).
- [road map of project](https://api.dihauti.ru)

## ENTITIES

### BlogCategory
**Fillable properties**
- name

**Guard properties**
- id
- slug
- created_at
- updated_at

**Relationship**
- BlogCategory -> _One To Many_ -> BlogPost

### BlogPost
**Fillable properties**
- title 
- body 
- description 
- blog_category_id

**Guard properties**
- id
- view_count
- slug
- user_id
- created_at
- updated_at

**Relationship**
- BlogPost -> _One To Many_ -> BlogComment
- BlogPost -> _One To Many (Polymorphic)_ -> Like
- BlogPost -> _One To Many Inversion_ -> BlogCategory
- BlogPost -> _One To Many Inversion_ -> User

### BlogComment
**Fillable properties**
- body 

**Guard properties**
- id
- post_id
- user_id
- created_at
- updated_at

**Relationship**
- BlogComment -> _One To Many (Polymorphic)_ -> Like
- BlogComment -> _One To Many Inversion_ -> BlogPost
- BlogComment -> _One To Many Inversion_ -> User

### ForumCategory
**Fillable properties**
- name

**Guard properties**
- id
- slug
- created_at
- updated_at

**Relationship**
- ForumCategory -> _One To Many_ -> ForumQuestion

### ForumQuestion
**Fillable properties**
- title 
- body 
- description 
- blog_category_id

**Guard properties**
- id
- view_count
- slug
- user_id
- created_at
- updated_at

**Relationship**
- ForumQuestion -> _One To Many_ -> ForumReply
- ForumQuestion -> _One To Many Polymorphic_ -> Like
- ForumQuestion -> _One To Many Inversion_ -> ForumCategory
- ForumQuestion -> _One To Many Inversion_ -> User

### ForumReply
**Fillable properties**
- body 

**Guard properties**
- id
- post_id
- user_id
- created_at
- updated_at

**Relationship**
- ForumReply -> _One To Many Polymorphic_ -> Like
- ForumReply -> _One To Many Inversion_ -> ForumQuestion
- ForumReply -> _One To Many Inversion_ -> User

### Like
**Fillable properties**
- user_id 

**Guard properties**
- id
- likable_id
- likable_type
- created_at
- updated_at

**Relationship**
- Like -> _One To Many Polymorphic Inversion_ -> BlogPost
- Like -> _One To Many Polymorphic Inversion_ -> BlogComment
- Like -> _One To Many Polymorphic Inversion_ -> ForumQuestion
- Like -> _One To Many Polymorphic Inversion_ -> ForumReply

### Dialog
**Fillable properties**
- recipient_id
- title 

**Guard properties**
- id
- sender_id
- created_at
- updated_at

**Relationship**
- Dialog -> _Many To Many_ -> User
- Like -> _One To Many_ -> Message

### Message
**Fillable properties**
- recipient_id
- title 

**Guard properties**
- id
- sender_id
- created_at
- updated_at

**Relationship**
- Dialog -> _Many To Many_ -> User
- Like -> _One To Many_ -> Message

### User
**Fillable properties**
- name
- email 
- password 
- verification_code 

**Guard properties**
- id
- verified
- slug
- created_at
- updated_at

**Relationship**
- User -> _One To One_ -> Profile
- User -> _One To Many_ -> ForumQuestion
- User -> _One To Many_ -> ForumReply
- User -> _One To Many_ -> BlogPost
- User -> _One To Many_ -> BlogComment
- User -> _One To Many_ -> Message
- User -> _One To Many_ -> Like
- User -> _Many To Many_ -> Role
- User -> _Many To Many_ -> Dialog


### Profile
**Fillable properties**
- first_name
- sex
- city
- quote

**Guard properties**
- id
- user_id
- created_at
- updated_at

**Relationship**
- Profile -> _One To One Inversion_ -> User

### Role
**Fillable properties**
- name

**Guard properties**
- id
- created_at
- updated_at

**Relationship**
- Role -> _Many To Many_ -> User

## ACTIONS

###BlogCategory

##### 1) GET - /blogCategories
**Access**: Public;

**Description**: Get all blog categories;

**Parameters**: No parameters;

**Response**:
- 200 - Blog's categories retrieved successfully
- 404 - Resource Not Found

##### 2) GET - /blogCategories/{slug}
**Access**: Public

**Description**: Get blog category with selected slug;

**Parameters**: 
- (string, required) slug in path;

**Response**:
- 200 - Blog category retrieved successfully
- 404 - Resource Not Found

##### 3) POST - /blogCategories
**Access**: Protected

**Description**: Add blog category in database;

**Parameters**: 
- (varchar, required) name in Request

**Response**:
- 201 - Blog category created successfully
- 400 - Bad request

##### 4) PUT - /blogCategories/{slug}
**Access**: Protected

**Description**: Update blog category in database;

**Parameters**: 
- (string, required) slug in path;
- (varchar) name in Request

**Response**:
- 202 - Blog category updated successfully
- 400 - Bad request

##### 5) DELETE - /blogCategories/{slug}
**Access**: Protected

**Description**: Delete blog category in database;

**Parameters**: 
- (string, required) slug in path;

**Response**:
- 202 - Blog category deleted successfully
- 400 - Bad request

###Post

##### 1) GET - /posts?page=
**Access**: Public;

**Description**: Get all posts with pagination;

**Parameters**:
- (int, required) page in path

**Response**:
- 200 - Blog posts retrieved successfully
- 404 - Resource Not Found

##### 2) GET - /posts/{slug}
**Access**: Public

**Description**: Get post with selected slug;

**Parameters**: 
- (string, required) slug in path;

**Response**:
- 200 - Post retrieved successfully
- 404 - Resource Not Found

##### 3) POST - /posts
**Access**: Protected

**Description**: Add post in database;

**Parameters**: 
- (varchar, required) title in Request
- (bigint, required) blog_category_id in Request
- (varchar, required) description in Request
- (longtext, required) body in Request

**Response**:
- 201 - Blog post created successfully
- 400 - Bad request

##### 4) PUT - /posts/{slug}
**Access**: Protected

**Description**: Update post in database;

**Parameters**: 
- (string, required) slug in path;
- (varchar) title in Request;
- (varchar) description in Request;
- (longtext) body in Request;

**Response**:
- 202 - Post updated successfully;
- 400 - Bad request;

##### 5) DELETE - /posts/{slug}
**Access**: Protected

**Description**: Delete post in database;

**Parameters**: 
- (string) slug in path;

**Response**:
- 202 - Post deleted successfully;
- 400 - Bad request;

###Comment

##### 1) GET - /posts/{slug}/comments?page=
**Access**: Public;

**Description**: Get all comments with pagination;

**Parameters**:
- (string) slug post in path;

**Response**:
- 200 - Comments for post retrieved successfully
- 404 - Resource Not Found

##### 2) GET - /posts/{slug}/comments/{id}
**Access**: Public

**Description**: Get comment with selected id;

**Parameters**: 
- (string, required) slug post in path;
- (int, required) id comment in path;

**Response**:
- 200 - Comment for post retrieved successfully
- 404 - Resource Not Found

##### 3) POST - /posts/{slug}/comments
**Access**: Protected

**Description**: Add comment in database;

**Parameters**:
- (string, required) slug post in path; 
- (int, required) blog_post_id in Request;
- (text, required) body in Request;

**Response**:
- 201 - Comment created successfully
- 400 - Bad request

##### 4) PUT - /posts/{slug}/comments/{id}
**Access**: Protected

**Description**: Update comment in database;

**Parameters**: 
- (int, required) id in path;
- (string, required) slug post in path; 
- (int) blog_post_id in Request;
- (text) body in Request;

**Response**:
- 202 - Comment updated successfully
- 400 - Bad request

##### 5) DELETE - /posts/{slug}/comments/{id}
**Access**: Protected

**Description**: Delete comment in database;

**Parameters**: 
- (int, required) id in path;
- (string, required) slug post in path;

**Response**:
- 202 - Comment deleted successfully
- 400 - Bad request

###ForumCategory

##### 1) GET - /forumCategories
**Access**: Public;

**Description**: Get all forum categories;

**Parameters**: No parameters;

**Response**:
- 200 - Forum's categories retrieved successfully
- 404 - Resource Not Found

##### 2) GET - /forumCategories/{slug}
**Access**: Public

**Description**: Get forum category with selected slug;

**Parameters**: 
- (string, required) slug in path;

**Response**:
- 200 - Forum category retrieved successfully
- 404 - Resource Not Found

##### 3) POST - /forumCategories
**Access**: Protected

**Description**: Add forum category in database;

**Parameters**: 
- (varchar, required) name in Request

**Response**:
- 201 - Forum category created successfully
- 400 - Bad request

##### 4) PUT - /forumCategories/{slug}
**Access**: Protected

**Description**: Update forum category in database;

**Parameters**: 
- (string, required) slug in path;
- (varchar) name in Request

**Response**:
- 202 - Forum category updated successfully
- 400 - Bad request

##### 5) DELETE - /forumCategories/{slug}
**Access**: Protected

**Description**: Delete forum category in database;

**Parameters**: 
- (string, required) slug in path;

**Response**:
- 202 - Forum category deleted successfully
- 400 - Bad request

###Questions

##### 1) GET - /questions?page=
**Access**: Public;

**Description**: Get all questions with pagination;

**Parameters**:
- (int, required) page in path

**Response**:
- 200 - Forum questions retrieved successfully
- 404 - Resource Not Found

##### 2) GET - /questions/{slug}
**Access**: Public

**Description**: Get question with selected slug;

**Parameters**: 
- (string, required) slug in path;

**Response**:
- 200 - Question retrieved successfully
- 404 - Resource Not Found

##### 3) POST - /questions
**Access**: Protected

**Description**: Add question in database;

**Parameters**: 
- (varchar, required) title in Request
- (bigint, required) forum_category_id in Request
- (longtext, required) body in Request

**Response**:
- 201 - Question created successfully
- 400 - Bad request

##### 4) PUT - /questions/{slug}
**Access**: Protected

**Description**: Update question in database;

**Parameters**: 
- (string, required) slug in path;
- (varchar) title in Request;
- (longtext) body in Request;

**Response**:
- 202 - Question updated successfully;
- 400 - Bad request;

##### 5) DELETE - /questions/{slug}
**Access**: Protected

**Description**: Delete question in database;

**Parameters**: 
- (string) slug in path;

**Response**:
- 202 - Question deleted successfully;
- 400 - Bad request;

###Comment

##### 1) GET - /questions/{slug}/replies?page=
**Access**: Public;

**Description**: Get all replies with pagination;

**Parameters**:
- (string) slug question in path;

**Response**:
- 200 - Replies for question retrieved successfully
- 404 - Resource Not Found

##### 2) GET - /questions/{slug}/replies/{id}
**Access**: Public

**Description**: Get replies with selected id;

**Parameters**: 
- (string, required) slug question in path;
- (int, required) id reply in path;

**Response**:
- 200 - Replies for question retrieved successfully
- 404 - Resource Not Found

##### 3) POST - /questions/{slug}/replies
**Access**: Protected

**Description**: Add reply in database;

**Parameters**:
- (string, required) slug question in path; 
- (int, required) forum_question_id in Request;
- (text, required) body in Request;

**Response**:
- 201 - Reply created successfully
- 400 - Bad request

##### 4) PUT - /questions/{slug}/replies/{id}
**Access**: Protected

**Description**: Update reply in database;

**Parameters**: 
- (int, required) id in path;
- (string, required) slug question in path; 
- (int) forum_question_id in Request;
- (text) body in Request;

**Response**:
- 202 - Reply updated successfully
- 400 - Bad request

##### 5) DELETE - /questions/{slug}/replies/{id}
**Access**: Protected

**Description**: Delete reply in database;

**Parameters**: 
- (int, required) id in path;
- (string, required) slug reply in path;

**Response**:
- 202 - Reply deleted successfully
- 400 - Bad request
