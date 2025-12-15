import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
 * @see app/Http/Controllers/DuspyController.php:78
 * @route '/posyandu/data-umum/store-multiple'
 */
export const storeMultiple = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.definition = {
    methods: ["post"],
    url: '/posyandu/data-umum/store-multiple',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
 * @see app/Http/Controllers/DuspyController.php:78
 * @route '/posyandu/data-umum/store-multiple'
 */
storeMultiple.url = (options?: RouteQueryOptions) => {
    return storeMultiple.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
 * @see app/Http/Controllers/DuspyController.php:78
 * @route '/posyandu/data-umum/store-multiple'
 */
storeMultiple.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\DuspyController::storeMultiple
 * @see app/Http/Controllers/DuspyController.php:78
 * @route '/posyandu/data-umum/store-multiple'
 */
    const storeMultipleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storeMultiple.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::storeMultiple
 * @see app/Http/Controllers/DuspyController.php:78
 * @route '/posyandu/data-umum/store-multiple'
 */
        storeMultipleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storeMultiple.url(options),
            method: 'post',
        })
    
    storeMultiple.form = storeMultipleForm
/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
const index1bf97c06f107348cc221b2a7dc7cdb53 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index1bf97c06f107348cc221b2a7dc7cdb53.url(options),
    method: 'get',
})

index1bf97c06f107348cc221b2a7dc7cdb53.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
index1bf97c06f107348cc221b2a7dc7cdb53.url = (options?: RouteQueryOptions) => {
    return index1bf97c06f107348cc221b2a7dc7cdb53.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
index1bf97c06f107348cc221b2a7dc7cdb53.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index1bf97c06f107348cc221b2a7dc7cdb53.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
index1bf97c06f107348cc221b2a7dc7cdb53.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index1bf97c06f107348cc221b2a7dc7cdb53.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
    const index1bf97c06f107348cc221b2a7dc7cdb53Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index1bf97c06f107348cc221b2a7dc7cdb53.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
        index1bf97c06f107348cc221b2a7dc7cdb53Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index1bf97c06f107348cc221b2a7dc7cdb53.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/posyandu/data-umum'
 */
        index1bf97c06f107348cc221b2a7dc7cdb53Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index1bf97c06f107348cc221b2a7dc7cdb53.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index1bf97c06f107348cc221b2a7dc7cdb53.form = index1bf97c06f107348cc221b2a7dc7cdb53Form
    /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
const index603b3440f1fb806f6ad9909e21f0ae40 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index603b3440f1fb806f6ad9909e21f0ae40.url(options),
    method: 'get',
})

index603b3440f1fb806f6ad9909e21f0ae40.definition = {
    methods: ["get","head"],
    url: '/api/duspy',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
index603b3440f1fb806f6ad9909e21f0ae40.url = (options?: RouteQueryOptions) => {
    return index603b3440f1fb806f6ad9909e21f0ae40.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
index603b3440f1fb806f6ad9909e21f0ae40.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index603b3440f1fb806f6ad9909e21f0ae40.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
index603b3440f1fb806f6ad9909e21f0ae40.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index603b3440f1fb806f6ad9909e21f0ae40.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
    const index603b3440f1fb806f6ad9909e21f0ae40Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index603b3440f1fb806f6ad9909e21f0ae40.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
        index603b3440f1fb806f6ad9909e21f0ae40Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index603b3440f1fb806f6ad9909e21f0ae40.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::index
 * @see app/Http/Controllers/DuspyController.php:12
 * @route '/api/duspy'
 */
        index603b3440f1fb806f6ad9909e21f0ae40Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index603b3440f1fb806f6ad9909e21f0ae40.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index603b3440f1fb806f6ad9909e21f0ae40.form = index603b3440f1fb806f6ad9909e21f0ae40Form

export const index = {
    '/posyandu/data-umum': index1bf97c06f107348cc221b2a7dc7cdb53,
    '/api/duspy': index603b3440f1fb806f6ad9909e21f0ae40,
}

/**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::create
 * @see app/Http/Controllers/DuspyController.php:62
 * @route '/posyandu/data-umum/create'
 */
        createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    create.form = createForm
/**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/posyandu/data-umum'
 */
const store1bf97c06f107348cc221b2a7dc7cdb53 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store1bf97c06f107348cc221b2a7dc7cdb53.url(options),
    method: 'post',
})

store1bf97c06f107348cc221b2a7dc7cdb53.definition = {
    methods: ["post"],
    url: '/posyandu/data-umum',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/posyandu/data-umum'
 */
store1bf97c06f107348cc221b2a7dc7cdb53.url = (options?: RouteQueryOptions) => {
    return store1bf97c06f107348cc221b2a7dc7cdb53.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/posyandu/data-umum'
 */
store1bf97c06f107348cc221b2a7dc7cdb53.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store1bf97c06f107348cc221b2a7dc7cdb53.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/posyandu/data-umum'
 */
    const store1bf97c06f107348cc221b2a7dc7cdb53Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store1bf97c06f107348cc221b2a7dc7cdb53.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/posyandu/data-umum'
 */
        store1bf97c06f107348cc221b2a7dc7cdb53Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store1bf97c06f107348cc221b2a7dc7cdb53.url(options),
            method: 'post',
        })
    
    store1bf97c06f107348cc221b2a7dc7cdb53.form = store1bf97c06f107348cc221b2a7dc7cdb53Form
    /**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy'
 */
const store603b3440f1fb806f6ad9909e21f0ae40 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store603b3440f1fb806f6ad9909e21f0ae40.url(options),
    method: 'post',
})

store603b3440f1fb806f6ad9909e21f0ae40.definition = {
    methods: ["post"],
    url: '/api/duspy',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy'
 */
store603b3440f1fb806f6ad9909e21f0ae40.url = (options?: RouteQueryOptions) => {
    return store603b3440f1fb806f6ad9909e21f0ae40.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy'
 */
store603b3440f1fb806f6ad9909e21f0ae40.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store603b3440f1fb806f6ad9909e21f0ae40.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy'
 */
    const store603b3440f1fb806f6ad9909e21f0ae40Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store603b3440f1fb806f6ad9909e21f0ae40.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::store
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy'
 */
        store603b3440f1fb806f6ad9909e21f0ae40Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store603b3440f1fb806f6ad9909e21f0ae40.url(options),
            method: 'post',
        })
    
    store603b3440f1fb806f6ad9909e21f0ae40.form = store603b3440f1fb806f6ad9909e21f0ae40Form

export const store = {
    '/posyandu/data-umum': store1bf97c06f107348cc221b2a7dc7cdb53,
    '/api/duspy': store603b3440f1fb806f6ad9909e21f0ae40,
}

/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
const showd4510655b10a6aa12d591d559f40915d = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showd4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'get',
})

showd4510655b10a6aa12d591d559f40915d.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/{id_posyandu}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
showd4510655b10a6aa12d591d559f40915d.url = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_posyandu: args.id_posyandu,
                }

    return showd4510655b10a6aa12d591d559f40915d.definition.url
            .replace('{id_posyandu}', parsedArgs.id_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
showd4510655b10a6aa12d591d559f40915d.get = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showd4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
showd4510655b10a6aa12d591d559f40915d.head = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showd4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
    const showd4510655b10a6aa12d591d559f40915dForm = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: showd4510655b10a6aa12d591d559f40915d.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
        showd4510655b10a6aa12d591d559f40915dForm.get = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: showd4510655b10a6aa12d591d559f40915d.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
        showd4510655b10a6aa12d591d559f40915dForm.head = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: showd4510655b10a6aa12d591d559f40915d.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    showd4510655b10a6aa12d591d559f40915d.form = showd4510655b10a6aa12d591d559f40915dForm
    /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
const show8e1f3434e42f295fcb67a4ffcb45b58e = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'get',
})

show8e1f3434e42f295fcb67a4ffcb45b58e.definition = {
    methods: ["get","head"],
    url: '/api/duspy/{duspy}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
show8e1f3434e42f295fcb67a4ffcb45b58e.url = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { duspy: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    duspy: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        duspy: args.duspy,
                }

    return show8e1f3434e42f295fcb67a4ffcb45b58e.definition.url
            .replace('{duspy}', parsedArgs.duspy.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
show8e1f3434e42f295fcb67a4ffcb45b58e.get = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
show8e1f3434e42f295fcb67a4ffcb45b58e.head = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
    const show8e1f3434e42f295fcb67a4ffcb45b58eForm = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
        show8e1f3434e42f295fcb67a4ffcb45b58eForm.get = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::show
 * @see app/Http/Controllers/DuspyController.php:131
 * @route '/api/duspy/{duspy}'
 */
        show8e1f3434e42f295fcb67a4ffcb45b58eForm.head = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show8e1f3434e42f295fcb67a4ffcb45b58e.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show8e1f3434e42f295fcb67a4ffcb45b58e.form = show8e1f3434e42f295fcb67a4ffcb45b58eForm

export const show = {
    '/posyandu/data-umum/{id_posyandu}': showd4510655b10a6aa12d591d559f40915d,
    '/api/duspy/{duspy}': show8e1f3434e42f295fcb67a4ffcb45b58e,
}

/**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
export const edit = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/{id_posyandu}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
edit.url = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_posyandu: args.id_posyandu,
                }

    return edit.definition.url
            .replace('{id_posyandu}', parsedArgs.id_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
edit.get = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
edit.head = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
    const editForm = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
        editForm.get = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::edit
 * @see app/Http/Controllers/DuspyController.php:141
 * @route '/posyandu/data-umum/{id_posyandu}/edit'
 */
        editForm.head = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
const updated4510655b10a6aa12d591d559f40915d = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updated4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'put',
})

updated4510655b10a6aa12d591d559f40915d.definition = {
    methods: ["put","patch"],
    url: '/posyandu/data-umum/{id_posyandu}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
updated4510655b10a6aa12d591d559f40915d.url = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_posyandu: args.id_posyandu,
                }

    return updated4510655b10a6aa12d591d559f40915d.definition.url
            .replace('{id_posyandu}', parsedArgs.id_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
updated4510655b10a6aa12d591d559f40915d.put = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updated4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
updated4510655b10a6aa12d591d559f40915d.patch = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updated4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
    const updated4510655b10a6aa12d591d559f40915dForm = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updated4510655b10a6aa12d591d559f40915d.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
        updated4510655b10a6aa12d591d559f40915dForm.put = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updated4510655b10a6aa12d591d559f40915d.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
        updated4510655b10a6aa12d591d559f40915dForm.patch = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updated4510655b10a6aa12d591d559f40915d.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updated4510655b10a6aa12d591d559f40915d.form = updated4510655b10a6aa12d591d559f40915dForm
    /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
const update8e1f3434e42f295fcb67a4ffcb45b58e = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'put',
})

update8e1f3434e42f295fcb67a4ffcb45b58e.definition = {
    methods: ["put","patch"],
    url: '/api/duspy/{duspy}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
update8e1f3434e42f295fcb67a4ffcb45b58e.url = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { duspy: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    duspy: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        duspy: args.duspy,
                }

    return update8e1f3434e42f295fcb67a4ffcb45b58e.definition.url
            .replace('{duspy}', parsedArgs.duspy.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
update8e1f3434e42f295fcb67a4ffcb45b58e.put = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
update8e1f3434e42f295fcb67a4ffcb45b58e.patch = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
    const update8e1f3434e42f295fcb67a4ffcb45b58eForm = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update8e1f3434e42f295fcb67a4ffcb45b58e.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
        update8e1f3434e42f295fcb67a4ffcb45b58eForm.put = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update8e1f3434e42f295fcb67a4ffcb45b58e.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\DuspyController::update
 * @see app/Http/Controllers/DuspyController.php:161
 * @route '/api/duspy/{duspy}'
 */
        update8e1f3434e42f295fcb67a4ffcb45b58eForm.patch = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update8e1f3434e42f295fcb67a4ffcb45b58e.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update8e1f3434e42f295fcb67a4ffcb45b58e.form = update8e1f3434e42f295fcb67a4ffcb45b58eForm

export const update = {
    '/posyandu/data-umum/{id_posyandu}': updated4510655b10a6aa12d591d559f40915d,
    '/api/duspy/{duspy}': update8e1f3434e42f295fcb67a4ffcb45b58e,
}

/**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
const destroyd4510655b10a6aa12d591d559f40915d = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyd4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'delete',
})

destroyd4510655b10a6aa12d591d559f40915d.definition = {
    methods: ["delete"],
    url: '/posyandu/data-umum/{id_posyandu}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
destroyd4510655b10a6aa12d591d559f40915d.url = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_posyandu: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_posyandu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_posyandu: args.id_posyandu,
                }

    return destroyd4510655b10a6aa12d591d559f40915d.definition.url
            .replace('{id_posyandu}', parsedArgs.id_posyandu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
destroyd4510655b10a6aa12d591d559f40915d.delete = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyd4510655b10a6aa12d591d559f40915d.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
    const destroyd4510655b10a6aa12d591d559f40915dForm = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroyd4510655b10a6aa12d591d559f40915d.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/posyandu/data-umum/{id_posyandu}'
 */
        destroyd4510655b10a6aa12d591d559f40915dForm.delete = (args: { id_posyandu: string | number } | [id_posyandu: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroyd4510655b10a6aa12d591d559f40915d.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroyd4510655b10a6aa12d591d559f40915d.form = destroyd4510655b10a6aa12d591d559f40915dForm
    /**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/api/duspy/{duspy}'
 */
const destroy8e1f3434e42f295fcb67a4ffcb45b58e = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'delete',
})

destroy8e1f3434e42f295fcb67a4ffcb45b58e.definition = {
    methods: ["delete"],
    url: '/api/duspy/{duspy}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/api/duspy/{duspy}'
 */
destroy8e1f3434e42f295fcb67a4ffcb45b58e.url = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { duspy: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    duspy: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        duspy: args.duspy,
                }

    return destroy8e1f3434e42f295fcb67a4ffcb45b58e.definition.url
            .replace('{duspy}', parsedArgs.duspy.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/api/duspy/{duspy}'
 */
destroy8e1f3434e42f295fcb67a4ffcb45b58e.delete = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy8e1f3434e42f295fcb67a4ffcb45b58e.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/api/duspy/{duspy}'
 */
    const destroy8e1f3434e42f295fcb67a4ffcb45b58eForm = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy8e1f3434e42f295fcb67a4ffcb45b58e.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\DuspyController::destroy
 * @see app/Http/Controllers/DuspyController.php:176
 * @route '/api/duspy/{duspy}'
 */
        destroy8e1f3434e42f295fcb67a4ffcb45b58eForm.delete = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy8e1f3434e42f295fcb67a4ffcb45b58e.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy8e1f3434e42f295fcb67a4ffcb45b58e.form = destroy8e1f3434e42f295fcb67a4ffcb45b58eForm

export const destroy = {
    '/posyandu/data-umum/{id_posyandu}': destroyd4510655b10a6aa12d591d559f40915d,
    '/api/duspy/{duspy}': destroy8e1f3434e42f295fcb67a4ffcb45b58e,
}

/**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
export const exportExcel = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportExcel.url(options),
    method: 'get',
})

exportExcel.definition = {
    methods: ["get","head"],
    url: '/api/duspy-export/excel',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
exportExcel.url = (options?: RouteQueryOptions) => {
    return exportExcel.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
exportExcel.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportExcel.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
exportExcel.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportExcel.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
    const exportExcelForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: exportExcel.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
        exportExcelForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportExcel.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::exportExcel
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/excel'
 */
        exportExcelForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportExcel.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    exportExcel.form = exportExcelForm
/**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
export const exportPdf = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdf.url(options),
    method: 'get',
})

exportPdf.definition = {
    methods: ["get","head"],
    url: '/api/duspy-export/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
exportPdf.url = (options?: RouteQueryOptions) => {
    return exportPdf.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
exportPdf.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdf.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
exportPdf.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportPdf.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
    const exportPdfForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: exportPdf.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
        exportPdfForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportPdf.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::exportPdf
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy-export/pdf'
 */
        exportPdfForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportPdf.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    exportPdf.form = exportPdfForm
/**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
export const printSingle = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: printSingle.url(args, options),
    method: 'get',
})

printSingle.definition = {
    methods: ["get","head"],
    url: '/api/duspy/{id}/print',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
printSingle.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return printSingle.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
printSingle.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: printSingle.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
printSingle.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: printSingle.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
    const printSingleForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: printSingle.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
        printSingleForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: printSingle.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DuspyController::printSingle
 * @see app/Http/Controllers/DuspyController.php:0
 * @route '/api/duspy/{id}/print'
 */
        printSingleForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: printSingle.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    printSingle.form = printSingleForm
const DuspyController = { storeMultiple, index, create, store, show, edit, update, destroy, exportExcel, exportPdf, printSingle }

export default DuspyController