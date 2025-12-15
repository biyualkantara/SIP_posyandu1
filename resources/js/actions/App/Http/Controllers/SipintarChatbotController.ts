import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SipintarChatbotController::index
 * @see app/Http/Controllers/SipintarChatbotController.php:12
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
 * @see app/Http/Controllers/SipintarChatbotController.php:12
 * @route '/sipintar/chatbot'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarChatbotController::index
 * @see app/Http/Controllers/SipintarChatbotController.php:12
 * @route '/sipintar/chatbot'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\SipintarChatbotController::index
 * @see app/Http/Controllers/SipintarChatbotController.php:12
 * @route '/sipintar/chatbot'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\SipintarChatbotController::index
 * @see app/Http/Controllers/SipintarChatbotController.php:12
 * @route '/sipintar/chatbot'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\SipintarChatbotController::index
 * @see app/Http/Controllers/SipintarChatbotController.php:12
 * @route '/sipintar/chatbot'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\SipintarChatbotController::index
 * @see app/Http/Controllers/SipintarChatbotController.php:12
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
const SipintarChatbotController = { index, ask }

export default SipintarChatbotController