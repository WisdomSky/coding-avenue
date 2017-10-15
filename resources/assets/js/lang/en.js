import enLocale from 'element-ui/lib/locale/lang/en';

export default {
    ...enLocale,
    site: {
      title: 'Coding Avenue'
    },
    auth: {
      login: {
          signIn: 'sign in'
      }
    },
    message: {
        loggingOut: 'Please wait, while we log you out...',
        loading: 'Loading...',
        updating: 'Updating...',
        saving: 'Saving...',
        processing: 'Processing...'
    },
    navigation: {
        dashboard: 'Dashboard',
        buttons: {
            logout: 'logout'
        }
    },
    post: {
        postedBy: 'Posted by <strong>{name}</strong> on {date}',
        readMore: 'Read more',
        pagination: {
            newer: 'Newer',
            older: 'Older'
        },
        buttons: {
            newPost: 'New Post',
            bulkActions: {
                label: 'Bulk Actions',
                publish: 'Publish',
                unpublish: 'Unpublish',
                delete: 'Delete'
            }
        },
        table: {
            labels: {
                title: 'Title',
                slug: 'Slug',
                status: 'Status',
                actions: 'Actions',
            },
            tags: {
                published: 'published',
                draft: 'draft'
            },
            tooltips: {
                unpublishPost: 'Unpublish Post',
                publishPost: 'Publish Post',
                deletePost: 'Delete Post'
            },
            noOfPosts: 'You have a total of {total} posts.'
        }
    },
    error: {
        unknownError: {
            title: 'An unknown error occured!',
            message: 'A page reload is required to fix this problem.',
            confirmButtonText: 'Reload'
        }
    }
}