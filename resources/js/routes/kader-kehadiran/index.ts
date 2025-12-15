import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\KaderKehadiranController::storeMultiple
 * @see app/Http/Controllers/KaderKehadiranController.php:126
 * @route '/kader-kehadiran/store-multiple'
 */
export const storeMultiple = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.definition = {
    methods: ["post"],
    url: '/kader-kehadiran/store-multiple',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::storeMultiple
 * @see app/Http/Controllers/KaderKehadiranController.php:126
 * @route '/kader-kehadiran/store-multiple'
 */
storeMultiple.url = (options?: RouteQueryOptions) => {
    return storeMultiple.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::storeMultiple
 * @see app/Http/Controllers/KaderKehadiranController.php:126
 * @route '/kader-kehadiran/store-multiple'
 */
storeMultiple.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::storeMultiple
 * @see app/Http/Controllers/KaderKehadiranController.php:126
 * @route '/kader-kehadiran/store-multiple'
 */
    const storeMultipleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storeMultiple.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::storeMultiple
 * @see app/Http/Controllers/KaderKehadiranController.php:126
 * @route '/kader-kehadiran/store-multiple'
 */
        storeMultipleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storeMultiple.url(options),
            method: 'post',
        })
    
    storeMultiple.form = storeMultipleForm
/**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/kader-kehadiran',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\KaderKehadiranController::index
 * @see app/Http/Controllers/KaderKehadiranController.php:34
 * @route '/kader-kehadiran'
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
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/kader-kehadiran/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\KaderKehadiranController::create
 * @see app/Http/Controllers/KaderKehadiranController.php:85
 * @route '/kader-kehadiran/create'
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
* @see \App\Http\Controllers\KaderKehadiranController::store
 * @see app/Http/Controllers/KaderKehadiranController.php:109
 * @route '/kader-kehadiran'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/kader-kehadiran',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::store
 * @see app/Http/Controllers/KaderKehadiranController.php:109
 * @route '/kader-kehadiran'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::store
 * @see app/Http/Controllers/KaderKehadiranController.php:109
 * @route '/kader-kehadiran'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::store
 * @see app/Http/Controllers/KaderKehadiranController.php:109
 * @route '/kader-kehadiran'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::store
 * @see app/Http/Controllers/KaderKehadiranController.php:109
 * @route '/kader-kehadiran'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
export const show = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/kader-kehadiran/{id_hadir}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
show.url = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_hadir: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_hadir: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_hadir: args.id_hadir,
                }

    return show.definition.url
            .replace('{id_hadir}', parsedArgs.id_hadir.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
show.get = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
show.head = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
    const showForm = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
        showForm.get = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\KaderKehadiranController::show
 * @see app/Http/Controllers/KaderKehadiranController.php:154
 * @route '/kader-kehadiran/{id_hadir}'
 */
        showForm.head = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
export const edit = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/kader-kehadiran/{id_hadir}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
edit.url = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_hadir: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_hadir: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_hadir: args.id_hadir,
                }

    return edit.definition.url
            .replace('{id_hadir}', parsedArgs.id_hadir.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
edit.get = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
edit.head = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
    const editForm = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
        editForm.get = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\KaderKehadiranController::edit
 * @see app/Http/Controllers/KaderKehadiranController.php:179
 * @route '/kader-kehadiran/{id_hadir}/edit'
 */
        editForm.head = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
export const update = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/kader-kehadiran/{id_hadir}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
update.url = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_hadir: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_hadir: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_hadir: args.id_hadir,
                }

    return update.definition.url
            .replace('{id_hadir}', parsedArgs.id_hadir.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
update.put = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
update.patch = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
    const updateForm = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
        updateForm.put = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\KaderKehadiranController::update
 * @see app/Http/Controllers/KaderKehadiranController.php:224
 * @route '/kader-kehadiran/{id_hadir}'
 */
        updateForm.patch = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\KaderKehadiranController::destroy
 * @see app/Http/Controllers/KaderKehadiranController.php:244
 * @route '/kader-kehadiran/{id_hadir}'
 */
export const destroy = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/kader-kehadiran/{id_hadir}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\KaderKehadiranController::destroy
 * @see app/Http/Controllers/KaderKehadiranController.php:244
 * @route '/kader-kehadiran/{id_hadir}'
 */
destroy.url = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_hadir: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id_hadir: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id_hadir: args.id_hadir,
                }

    return destroy.definition.url
            .replace('{id_hadir}', parsedArgs.id_hadir.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KaderKehadiranController::destroy
 * @see app/Http/Controllers/KaderKehadiranController.php:244
 * @route '/kader-kehadiran/{id_hadir}'
 */
destroy.delete = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\KaderKehadiranController::destroy
 * @see app/Http/Controllers/KaderKehadiranController.php:244
 * @route '/kader-kehadiran/{id_hadir}'
 */
    const destroyForm = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\KaderKehadiranController::destroy
 * @see app/Http/Controllers/KaderKehadiranController.php:244
 * @route '/kader-kehadiran/{id_hadir}'
 */
        destroyForm.delete = (args: { id_hadir: string | number } | [id_hadir: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const kaderKehadiran = {
    storeMultiple: Object.assign(storeMultiple, storeMultiple),
index: Object.assign(index, index),
create: Object.assign(create, create),
store: Object.assign(store, store),
show: Object.assign(show, show),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default kaderKehadiran