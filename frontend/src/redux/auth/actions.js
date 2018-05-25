const actions = {
  AUTH_ACTION: 'AUTH_ACTION',
  authAction: (auth) => ({
    type: actions.AUTH_ACTION,
    auth
  }),
}

export default actions
