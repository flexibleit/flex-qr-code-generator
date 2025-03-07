const TypeSelector = ({ selectedValue, setSelectedValue }) => {
  const values = ['svg', 'png', 'jpg', 'pdf', 'eps'];

  const handleChange = (value) => {
    setSelectedValue(value);
  };

  return (
    <div className='flex flex-col gap-2'>
      <label
        className='text-sm font-medium text-gray-900 dark:text-white'
        htmlFor='type-selector'
      >
        Save/Download As
      </label>
      <select
        className='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
        id='type-selector'
        onChange={(e) => handleChange(e.target.value)}
      >
        {values.map((value) => {
          return <option value={value}>{value.toUpperCase()}</option>;
        })}
      </select>
    </div>
  );
};
export default TypeSelector;
