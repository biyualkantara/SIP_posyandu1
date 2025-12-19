import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\SipintarChatbotController::api
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
export const api = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: api.url(options),
    method: 'post',
})

api.definition = {
    methods: ["post"],
    url: '/sipintar/chatbot/api',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SipintarChatbotController::api
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
api.url = (options?: RouteQueryOptions) => {
    return api.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarChatbotController::api
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
api.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: api.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::api
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
const apiForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: api.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::api
* @see app/Http/Controllers/SipintarChatbotController.php:21
* @route '/sipintar/chatbot/api'
*/
apiForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: api.url(options),
    method: 'post',
})

api.form = apiForm

const chatbot = {
    api: Object.assign(api, api),
}

export default chatbot