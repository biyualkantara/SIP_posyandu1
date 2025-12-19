import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
export const predictAll = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: predictAll.url(options),
    method: 'post',
})

predictAll.definition = {
    methods: ["post"],
    url: '/ai/stunting/predict-all',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
predictAll.url = (options?: RouteQueryOptions) => {
    return predictAll.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
predictAll.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: predictAll.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
const predictAllForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: predictAll.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
predictAllForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: predictAll.url(options),
    method: 'post',
})

predictAll.form = predictAllForm

const stunting = {
    predictAll: Object.assign(predictAll, predictAll),
}

export default stunting