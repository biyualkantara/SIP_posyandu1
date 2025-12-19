import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/sipintar/chatbot',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\SipintarChatbotController::handle
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
export const handle = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

handle.definition = {
    methods: ["post"],
    url: '/sipintar/chatbot/api',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SipintarChatbotController::handle
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
handle.url = (options?: RouteQueryOptions) => {
    return handle.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarChatbotController::handle
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
handle.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::handle
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
const handleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handle.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::handle
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
handleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handle.url(options),
    method: 'post',
})

handle.form = handleForm

const SipintarChatbotController = { index, handle }

export default SipintarChatbotController