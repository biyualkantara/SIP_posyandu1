import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import chatbot45ee68 from './chatbot'
/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
export const chatbot = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: chatbot.url(options),
    method: 'get',
})

chatbot.definition = {
    methods: ["get","head"],
    url: '/sipintar/chatbot',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
chatbot.url = (options?: RouteQueryOptions) => {
    return chatbot.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
chatbot.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: chatbot.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
chatbot.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: chatbot.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
const chatbotForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: chatbot.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
chatbotForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: chatbot.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarChatbotController::chatbot
* @see app/Http/Controllers/SipintarChatbotController.php:13
* @route '/sipintar/chatbot'
*/
chatbotForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: chatbot.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

chatbot.form = chatbotForm

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
export const stunting = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stunting.url(options),
    method: 'get',
})

stunting.definition = {
    methods: ["get","head"],
    url: '/sipintar/stunting',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
stunting.url = (options?: RouteQueryOptions) => {
    return stunting.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
stunting.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stunting.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
stunting.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: stunting.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
const stuntingForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: stunting.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
stuntingForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: stunting.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SipintarStuntingController::stunting
* @see app/Http/Controllers/SipintarStuntingController.php:10
* @route '/sipintar/stunting'
*/
stuntingForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: stunting.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

stunting.form = stuntingForm

const sipintar = {
    chatbot: Object.assign(chatbot, chatbot45ee68),
    stunting: Object.assign(stunting, stunting),
}

export default sipintar