import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictForAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
export const predictForAll = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: predictForAll.url(options),
    method: 'post',
})

predictForAll.definition = {
    methods: ["post"],
    url: '/ai/stunting/predict-all',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictForAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
predictForAll.url = (options?: RouteQueryOptions) => {
    return predictForAll.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictForAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
predictForAll.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: predictForAll.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictForAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
const predictForAllForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: predictForAll.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AiStuntingPredictController::predictForAll
* @see app/Http/Controllers/AiStuntingPredictController.php:10
* @route '/ai/stunting/predict-all'
*/
predictForAllForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: predictForAll.url(options),
    method: 'post',
})

predictForAll.form = predictForAllForm

const AiStuntingPredictController = { predictForAll }

export default AiStuntingPredictController