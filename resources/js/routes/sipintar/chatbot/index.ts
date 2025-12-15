import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\SipintarChatbotController::ask
 * @see app/Http/Controllers/SipintarChatbotController.php:18
 * @route '/sipintar/chatbot/ask'
 */
export const ask = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ask.url(options),
    method: 'post',
})

ask.definition = {
    methods: ["post"],
    url: '/sipintar/chatbot/ask',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SipintarChatbotController::ask
 * @see app/Http/Controllers/SipintarChatbotController.php:18
 * @route '/sipintar/chatbot/ask'
 */
ask.url = (options?: RouteQueryOptions) => {
    return ask.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarChatbotController::ask
 * @see app/Http/Controllers/SipintarChatbotController.php:18
 * @route '/sipintar/chatbot/ask'
 */
ask.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ask.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\SipintarChatbotController::ask
 * @see app/Http/Controllers/SipintarChatbotController.php:18
 * @route '/sipintar/chatbot/ask'
 */
    const askForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: ask.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\SipintarChatbotController::ask
 * @see app/Http/Controllers/SipintarChatbotController.php:18
 * @route '/sipintar/chatbot/ask'
 */
        askForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: ask.url(options),
            method: 'post',
        })
    
    ask.form = askForm
const chatbot = {
    ask: Object.assign(ask, ask),
}

export default chatbot