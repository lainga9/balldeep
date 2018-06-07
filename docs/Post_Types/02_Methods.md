The post model has the following methods available to use in templates:

    title()

returns the title of the post - **string**

    content()

returns the content of the post - **string**

    url()

returns the link to view the post - **string**

    excerpt()

returns the excerpt (short version of the content) for the post - **string**

    meta($key)

returns any additional meta which has been attached to the post - **mixed**

    publishedAt($format = 'dS M y g:ia')

returns the date on which the post was initially published - **string**

    updatedAt($format = 'dS M y g:ia')

returns the date on which the post was last updated - **string**