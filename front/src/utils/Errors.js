export default class Errors {

  /**
   * Create a new Errors instance.
   */
  constructor() {
    this.errors = {}
  }

  /**
   * Determine if an errors exists for the given field.
   *
   * @param {string} field
   */
  has(field) {
    return Object.prototype.hasOwnProperty.call(this.errors, field)
  }

  /**
   * Determine if we have any errors.
   */
  any() {
    return Object.keys(this.errors).length > 0
  }

  /**
   * Retrieve the error message for a field.
   *
   * @param {string} field
   */
  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0]
    }
  }

  /**
   * Record the new errors.
   *
   * @param {object} errors
   */
  record(errors) {
    this.errors = errors
  }

  /**
   * Clear one and all fields
   *
   * @param {string|null} field
   */
  clear(field = null) {

    if (field) {
      this.errors[field] = null

      delete this.errors[field]

      return
    }

    this.errors = {}
  }
}