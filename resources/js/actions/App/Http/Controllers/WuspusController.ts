import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/wuspus/biodata',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\WuspusController::index
 * @see app/Http/Controllers/WuspusController.php:12
 * @route '/wuspus/biodata'
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
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/wuspus/biodata/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\WuspusController::create
 * @see app/Http/Controllers/WuspusController.php:93
 * @route '/wuspus/biodata/create'
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
* @see \App\Http\Controllers\WuspusController::store
 * @see app/Http/Controllers/WuspusController.php:118
 * @route '/wuspus/biodata'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/wuspus/biodata',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\WuspusController::store
 * @see app/Http/Controllers/WuspusController.php:118
 * @route '/wuspus/biodata'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::store
 * @see app/Http/Controllers/WuspusController.php:118
 * @route '/wuspus/biodata'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\WuspusController::store
 * @see app/Http/Controllers/WuspusController.php:118
 * @route '/wuspus/biodata'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\WuspusController::store
 * @see app/Http/Controllers/WuspusController.php:118
 * @route '/wuspus/biodata'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
export const show = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/wuspus/biodata/{id_wuspus}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
show.url = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_wuspus: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_wuspus: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_wuspus: args.id_wuspus,
                }

    return show.definition.url
            .replace('{id_wuspus}', parsedArgs.id_wuspus.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
show.get = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
show.head = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
    const showForm = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
        showForm.get = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\WuspusController::show
 * @see app/Http/Controllers/WuspusController.php:152
 * @route '/wuspus/biodata/{id_wuspus}'
 */
        showForm.head = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
export const edit = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/wuspus/biodata/{id_wuspus}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
edit.url = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_wuspus: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_wuspus: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_wuspus: args.id_wuspus,
                }

    return edit.definition.url
            .replace('{id_wuspus}', parsedArgs.id_wuspus.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
edit.get = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
edit.head = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
    const editForm = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
        editForm.get = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\WuspusController::edit
 * @see app/Http/Controllers/WuspusController.php:164
 * @route '/wuspus/biodata/{id_wuspus}/edit'
 */
        editForm.head = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
export const update = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/wuspus/biodata/{id_wuspus}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
update.url = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_wuspus: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_wuspus: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_wuspus: args.id_wuspus,
                }

    return update.definition.url
            .replace('{id_wuspus}', parsedArgs.id_wuspus.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
update.put = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
update.patch = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
    const updateForm = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
        updateForm.put = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\WuspusController::update
 * @see app/Http/Controllers/WuspusController.php:178
 * @route '/wuspus/biodata/{id_wuspus}'
 */
        updateForm.patch = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\WuspusController::destroy
 * @see app/Http/Controllers/WuspusController.php:205
 * @route '/wuspus/biodata/{id_wuspus}'
 */
export const destroy = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/wuspus/biodata/{id_wuspus}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\WuspusController::destroy
 * @see app/Http/Controllers/WuspusController.php:205
 * @route '/wuspus/biodata/{id_wuspus}'
 */
destroy.url = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_wuspus: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_wuspus: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_wuspus: args.id_wuspus,
                }

    return destroy.definition.url
            .replace('{id_wuspus}', parsedArgs.id_wuspus.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\WuspusController::destroy
 * @see app/Http/Controllers/WuspusController.php:205
 * @route '/wuspus/biodata/{id_wuspus}'
 */
destroy.delete = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\WuspusController::destroy
 * @see app/Http/Controllers/WuspusController.php:205
 * @route '/wuspus/biodata/{id_wuspus}'
 */
    const destroyForm = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\WuspusController::destroy
 * @see app/Http/Controllers/WuspusController.php:205
 * @route '/wuspus/biodata/{id_wuspus}'
 */
        destroyForm.delete = (args: { id_wuspus: string | number } | [id_wuspus: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const WuspusController = { index, create, store, show, edit, update, destroy }

export default WuspusController