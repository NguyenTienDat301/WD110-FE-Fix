import { useState, useEffect } from "react";
import api from "../../Axios/Axios";
import { message } from "antd";
import { ArrowRightOutlined } from "@ant-design/icons";
import { Size, Color } from "../../types/cart";
import "./ProductComponent.css";

interface AsideFilterProps {
  setFilters: React.Dispatch<
    React.SetStateAction<{
      category: string | null;
      size: string | null;
      color: string | null;
      priceRange: [number, number] | null;
      brands: string[];
    }>
  >;
}

// ================= Category Filter =================
const CategoryFilter = ({
  categories,
  selectedCategory,
  onChange,
}: {
  categories: any[];
  selectedCategory: string | null;
  onChange: (categoryName: string) => void;
}) => {
  return (
    <div className="block-filter">
      <h6 style={{ marginBottom: "15px", fontFamily: "Raleway" }}>Danh mục</h6>
      <div className="box-collapse">
        <ul className="list-filter-checkbox">
          {categories.map((category) => (
            <li key={category.id}>
              <label className="cb-container">
                <input
                  type="checkbox"
                  checked={selectedCategory === category.name}
                  onChange={() => onChange(category.name)}
                />
                <span style={{ fontFamily: "Raleway" }} className="text-small">
                  {category.name}
                </span>
                <span className="checkmark" />
              </label>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

// ================= Price Filter =================
const PriceFilter = ({
  priceRange,
  onChange,
}: {
  priceRange: [number, number] | null;
  onChange: (range: [number, number]) => void;
}) => {
  const priceOptions = [
    { label: "Dưới 500.000đ", range: [0, 499999] },
    { label: "Từ 500.000đ → 1.000.000đ", range: [500000, 1000000] },
    { label: "Từ 1.000.000đ → 1.500.000đ", range: [1000000, 1500000] },
    { label: "Từ 1.500.000đ → 2.000.000đ", range: [1500000, 2000000] },
    { label: "Trên 2.000.000đ", range: [2000000, Infinity] },
  ];

  return (
    <div className="block-filter">
      <h6 style={{ marginBottom: "15px", fontFamily: "Raleway" }}>Giá tiền</h6>
      <div className="box-collapse">
        <ul className="list-filter-checkbox">
          {priceOptions.map((option, index) => (
            <li key={index}>
              <label className="cb-container">
                <input
                  type="checkbox"
                  checked={
                    priceRange?.[0] === option.range[0] &&
                    priceRange?.[1] === option.range[1]
                  }
                  onChange={() => onChange(option.range as [number, number])}
                />
                <span className="text-small">
                  {option.label.includes("→") ? (
                    <>
                      {option.label.split("→")[0]}{" "}
                      <ArrowRightOutlined /> {option.label.split("→")[1]}
                    </>
                  ) : (
                    option.label
                  )}
                </span>
                <span className="checkmark" />
              </label>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

// ================= Size Filter =================
const SizeFilter = ({
  sizes,
  selectedSize,
  onClick,
}: {
  sizes: Size[];
  selectedSize: string | null;
  onClick: (size: string) => void;
}) => {
  return (
    <div className="block-filter" style={{ cursor: "pointer" }}>
      <h6 style={{ marginBottom: "15px", fontFamily: "Raleway" }}>Size</h6>
      <div className="box-collapse">
        <div className="block-size">
          <div className="list-sizes">
            {sizes.map((size, index) => (
              <span
                key={index}
                className={selectedSize === size.size ? "active" : ""}
                style={{ fontFamily: "Raleway" }}
                onClick={() => onClick(size.size)}
              >
                {size.size}
              </span>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

// ================= Color Filter =================
const ColorFilter = ({
  colors,
  selectedColor,
  onClick,
}: {
  colors: Color[];
  selectedColor: string | null;
  onClick: (color: string) => void;
}) => {
  return (
    <div className="block-filter">
      <h6 style={{ marginBottom: "15px", fontFamily: "Raleway" }}>Màu sắc</h6>
      <div className="box-collapse">
        <div className="list-color">
          {colors.map((color) => (
            <span
              key={color.id}
              style={{
                padding: "7px 8px",
                cursor: "pointer",
                fontFamily: "Raleway",
              }}
              className={
                selectedColor === color.name_color
                  ? "active"
                  : "filter-color"
              }
              onClick={() => onClick(color.name_color)}
            >
              <span style={{ fontFamily: "Raleway" }} className="box-color">
                {color.name_color}
              </span>
            </span>
          ))}
        </div>
      </div>
    </div>
  );
};

// ================= Main Aside Filter =================
const AsideFilter: React.FC<AsideFilterProps> = ({ setFilters }) => {
  const [categories, setCategories] = useState<any[]>([]);
  const [sizes, setSizes] = useState<Size[]>([]);
  const [colors, setColors] = useState<Color[]>([]);
  const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
  const [priceRange, setPriceRange] = useState<[number, number] | null>(null);
  const [selectedSize, setSelectedSize] = useState<string | null>(null);
  const [selectedColor, setSelectedColor] = useState<string | null>(null);

  // Fetch API
  const GetAllCategory = async () => {
    try {
      const { data } = await api.get("/categories");
      setCategories(data);
    } catch {
      message.error("Lỗi api danh mục!");
    }
  };

  const GetAllProducts = async () => {
    try {
      const { data } = await api.get("/products");
      setSizes(data.all_sizes);
      setColors(data.all_colors);
    } catch {
      message.error("Lỗi api sản phẩm!");
    }
  };

  useEffect(() => {
    GetAllCategory();
    GetAllProducts();
  }, []);

  // Handlers
  const handleCategoryChange = (categoryName: string) => {
    if (selectedCategory === categoryName) {
      setSelectedCategory(null);
      setFilters((prev) => ({ ...prev, category: null }));
    } else {
      setSelectedCategory(categoryName);
      setFilters((prev) => ({ ...prev, category: categoryName }));
    }
  };

  const handlePriceChange = (range: [number, number]) => {
    if (priceRange?.[0] === range[0] && priceRange?.[1] === range[1]) {
      setPriceRange(null);
      setFilters((prev) => ({ ...prev, priceRange: null }));
    } else {
      setPriceRange(range);
      setFilters((prev) => ({ ...prev, priceRange: range }));
    }
  };

  const handleSizeClick = (size: string) => {
    setSelectedSize(size === selectedSize ? null : size);
    setFilters((prev) => ({ ...prev, size: prev.size === size ? null : size }));
  };

  const handleColorClick = (color: string) => {
    setSelectedColor(color === selectedColor ? null : color);
    setFilters((prev) => ({
      ...prev,
      color: prev.color === color ? null : color,
    }));
  };

  return (
    <div className="col-lg-3 order-lg-first">
      <div className="sidebar-left">
        <div className="box-filters-sidebar">
          <div className="row">
            <div className="col-lg-12 col-md-6">
              <h5
                style={{ fontFamily: "Raleway" }}
                className="font-3xl-bold mt-5"
              >
                Lọc sản phẩm
              </h5>
              <CategoryFilter
                categories={categories}
                selectedCategory={selectedCategory}
                onChange={handleCategoryChange}
              />
            </div>

            <div className="col-lg-12 col-md-6">
              <PriceFilter priceRange={priceRange} onChange={handlePriceChange} />
            </div>

            <div className="col-lg-12 col-md-6">
              <SizeFilter
                sizes={sizes}
                selectedSize={selectedSize}
                onClick={handleSizeClick}
              />
            </div>

            <div className="col-lg-12 col-md-6">
              <ColorFilter
                colors={colors}
                selectedColor={selectedColor}
                onClick={handleColorClick}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AsideFilter;
