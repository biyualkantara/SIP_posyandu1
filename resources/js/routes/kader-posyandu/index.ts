import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/kader-posyandu',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\KaderPosyanduController::index
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
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
* @see \App\Http\Controllers\KaderPosyanduController::store
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/kader-posyandu',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\KaderPosyanduController::store
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderPosyanduController::store
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\KaderPosyanduController::store
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderPosyanduController::store
 * @see [unknown]:0
 * @route '/api/kader-posyandu'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
export const show = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/kader-posyandu/{kader_posyandu}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
show.url = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { kader_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    kader_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        kader_posyandu: args.kader_posyandu,
                }

    return show.definition.url
            .replace('{kader_posyandu}', parsedArgs.kader_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
show.get = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
show.head = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
    const showForm = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
        showForm.get = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\KaderPosyanduController::show
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
        showForm.head = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
export const update = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/kader-posyandu/{kader_posyandu}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
update.url = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { kader_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    kader_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        kader_posyandu: args.kader_posyandu,
                }

    return update.definition.url
            .replace('{kader_posyandu}', parsedArgs.kader_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
update.put = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
update.patch = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
    const updateForm = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
        updateForm.put = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\KaderPosyanduController::update
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
        updateForm.patch = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\KaderPosyanduController::destroy
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
export const destroy = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/kader-posyandu/{kader_posyandu}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\KaderPosyanduController::destroy
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
destroy.url = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { kader_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    kader_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        kader_posyandu: args.kader_posyandu,
                }

    return destroy.definition.url
            .replace('{kader_posyandu}', parsedArgs.kader_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderPosyanduController::destroy
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
destroy.delete = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\KaderPosyanduController::destroy
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
    const destroyForm = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderPosyanduController::destroy
 * @see [unknown]:0
 * @route '/api/kader-posyandu/{kader_posyandu}'
 */
        destroyForm.delete = (args: { kader_posyandu: string | number } | [kader_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const kaderPosyandu = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
show: Object.assign(show, show),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default kaderPosyandu