const Button = ({ onClick, value, disabled }) => {
  return (
    <div>
      <button
        className='button button-primary inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800'
        onClick={onClick}
        disabled={disabled}
      >
        {value}
      </button>
    </div>
  );
};
export default Button;
